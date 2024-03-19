<template>
    <div class="row" style="height: 35wh;">

        <div class="col-6 col-md-6 col-sm-6 col-lg-3  mb-2" v-for="product in products" :key="product.id">
            <div class="card" id="card" style="max-width: 300px; box-shadow: 5px 5px 5px gray; position: relative;">
                <!-- Dodajte ikonu za favorite u gornji desni ugao kartice -->
                <i v-if="user" :class="{ 'fas fa-heart': isInFavorites(product.id), 'far fa-heart': !isInFavorites(product.id), 'text-danger': isInFavorites(product.id) }" @click="toggleFavorite(product)" style="position: absolute; top: 5px; right: 5px; font-size: 20px;"></i>

                <router-link :to="{ name: 'thisProduct', params: { id: product.id, productName: removeSpace(product.name) }}" style="text-decoration: none;">
                    <div class="card-header">
                        <img class="img-fluid w-100" :src="getAbsoluteImagePath(product.boutique[0].name, product.image1)" alt=""/>
                        <div class="product-img position-relative overflow-hidden"></div>
                    </div>

                    <div class="card-body" style="padding: 0">
                        <h3 class="card-title naslov">{{ product.name }}</h3>
                        <h4 class="card-subtitle mb-2 float-start naslov" style="color: #65B741">{{ product.price }}KM</h4>
                        <small class="card-subtitle mb-2 float-right podnaslov" v-if="product.old_price != 0" style="color: #B80000">
                            <del>{{ product.old_price }} KM</del>
                        </small>
                    </div>
                </router-link>
                <div class="card-footer" style="padding: 2px">
                    <router-link :to="{ name: 'boutique-page', params: { boutiqueName: removeSpace(boutique.name) }}" v-for="boutique in product.boutique" :key="boutique.id">
                        <button style="border-radius: 5px" class="badge badge-info bg-sm float-end mobile-button"><b>{{ boutique.name }}</b></button>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: window.user || null,
            inFavorites: [],
        }
    },
    props: {
        products: {
            type: Array,
            required: true
        },

        // remove: {
        //     type: Function,
        //     required: true
        // }



    },
    created() {
        if (this.user) {
            this.loadFavorites();
        }
    },
    methods: {
        getAbsoluteImagePath(boutiqueName, imageName) {
            return `http://127.0.0.1:8000/images/${boutiqueName}/${imageName}`;
        },
        removeSpace(name) {
            return name.replace(/\s+/g, '-');
        },
        async loadFavorites() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/products/all-fav');
                this.inFavorites = response.data[1];
                console.log('MyFav:',response.data[1]);
            } catch (error) {
                console.error('Error loading favorites:', error);
            }
        },
        toggleFavorite(product) {
            if (this.isInFavorites(product.id)) {
                this.removeFromFavorites(product.id);
                // this.$emit('toggle-favorite', product.id);
            } else {
                this.addToFavorites(product.id);
            }
        },
        isInFavorites(productId) {
            return this.inFavorites.some(favorite => favorite.product_id === productId);
        },
        async addToFavorites(productId) {
            try {
                await axios.get(`http://127.0.0.1:8000/api/product/add-to-fav/${productId}`);
                this.inFavorites.push({ product_id: productId });
            } catch (error) {
                console.error('Error adding to favorites:', error);
            }
        },
        async removeFromFavorites(productId) {
            try {
                await axios.get(`http://127.0.0.1:8000/api/product/remove-fav/${productId}`);
                this.inFavorites = this.inFavorites.filter(favorite => favorite.product_id !== productId);
                this.$emit('remove-from-favorites', productId);
                console.log('Remove product kartica:',productId);
            } catch (productId) {
                console.error('Error removing from favorites(komponenta kartica):', productId);
            }
        },
    }
}
</script>
