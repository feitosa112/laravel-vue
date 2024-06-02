<template>
    <div>
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Edit</span>
        </h2>
        <div class="alert alert-success" v-if="update">{{ updateMessage }}</div>
        <div class="col-6 offset-3">
            <form @submit.prevent="updateProduct">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" v-model="product.name">
                </div>

                <div class="form-group">
                    <label for="image1">Image 1</label>
                    <img :src="getAbsoluteImagePath(product.boutique[0].name, product.image1)" alt="" style="height: 50px; width: 50px;">
                    <input type="file" @change="handleImageChange('image1', $event)" name="image1" class="form-control">
                </div>

                <div class="form-group">
                    <label for="image2">Image 2</label>
                    <img v-if="product.image2 != null" :src="getAbsoluteImagePath(product.boutique[0].name, product.image2)" alt="" style="height: 50px; width: 50px;">
                    <input type="file" @change="handleImageChange('image2', $event)" name="image2" class="form-control">
                </div>

                <div class="form-group">
                    <label for="image3">Image 3</label>
                    <img v-if="product.image3 != null" :src="getAbsoluteImagePath(product.boutique[0].name, product.image3)" alt="" style="height: 50px; width: 50px;">
                    <input type="file" @change="handleImageChange('image3', $event)" name="image3" class="form-control">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" v-model="product.price">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" v-model="product.description"></textarea>
                </div>

                <div class="form-group">
                    <label for="old_price">Old Price</label>
                    <input type="number" class="form-control" id="old_price" v-model="product.old_price">
                </div>

                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" class="form-control" id="color" v-model="product.color">
                </div>

                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" class="form-control" id="size" v-model="product.size">
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            apiUrl: window.apiUrl,
            product: null,
            update: false,
            updateMessage: null,
            image1: null,
            image2: null,
            image3: null
        }
    },
    mounted() {
        this.getProduct();
    },
    methods: {
        async getProduct() {
            try {
                const id = this.$route.params.id;
                console.log(this.$route.params.id);
                const response = await this.$axios.get(`${this.apiUrl}/admin/edit-product/${id}`);
                this.product = response.data;
                console.log('Product za edit:', response.data);
            } catch (error) {
                console.error('Error fetching product details:', error.message);
            }
        },
        handleImageChange(inputName, event) {
            console.log('Event:', event);
            const file = event.target.files[0];
            console.log('File:', file);
            if (file) {
                this[inputName] = file;
            } else {
                this[inputName] = null;
            }
        },
        async updateProduct() {
    try {
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        const formData = new FormData();
        formData.append('_method', 'PUT');  // Laravel expects _method for PUT requests via FormData
        formData.append('name', this.product.name);
        formData.append('category_id', this.product.category_id);
        formData.append('subcategory_id', this.product.subcategory_id);
        formData.append('price', this.product.price);
        formData.append('old_price', this.product.old_price);
        formData.append('description', this.product.description);
        formData.append('color', this.product.color);
        formData.append('size', this.product.size);

        if (this.image1) formData.append('image1', this.image1);
        if (this.image2) formData.append('image2', this.image2);
        if (this.image3) formData.append('image3', this.image3);

        // Log the formData entries to check the values
        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        const id = this.$route.params.id;
        const response = await this.$axios.post(`${this.apiUrl}/admin/update-product/${id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        });

        this.update = true;
        this.updateMessage = response.data.message;
        console.log('Product updated successfully:', response.data);
    } catch (error) {
        console.error('Error updating product:', error.message);
    }
},
        getAbsoluteImagePath(boutiqueName, imageName) {
            return `http://127.0.0.1:8000/images/${boutiqueName}/${imageName}`;
        }
    }
}
</script>
