<template>
   <h3 v-if="products.length === 0">Trenutno nema proizvoda za ovu kategoriju</h3>

<div class="container-fluid" v-else>


        <div class="row">
            <div class="col-lg-3 col-6 col-md-6 col-sm-6" v-for="product in products">
                <router-link :to="{ name: 'thisProduct', params: { id: product.id,productName:removeSpace(product.name) }}" style="text-decoration: none;">
                        <div class="card" id="card" style="max-width: 300px;box-shadow:5px 5px 5px gray">
                            <div class="card-header">
                                <img class="img-fluid w-100" :src="getAbsoluteImagePath(product.image1)" alt="">
                                <div class="product-img position-relative overflow-hidden">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                                </div>
                            </div>

                        <div class="card-body" style="padding: 0">
                            <h3 class="card-title naslov">{{ product.name }}</h3>
                            <h4 class="card-subtitle mb-2 float-start naslov" style="color: #65B741">{{ product.price }}KM</h4>
                            <small class="card-subtitle mb-2 float-right podnaslov" v-if="product.old_price !=null" style="color: #B80000"><del>{{product.old_price}} KM</del></small>
                        </div>

                        <div class="card-footer" style="padding: 2px">
                            <a href="" style="border-radius: 5px" class="btn btn-primary btn-sm float-start mobile-button">Kupi</a>
                        </div>

                        </div>
                    </router-link>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            products:[]
        }
    },
    mounted(){
        console.log('Mount start');
        this.getProductsWithSubCategory();
        console.log('Mount end');

    },
    methods:{
        async getProductsWithSubCategory() {

    const subcategory_id = this.$route.params.subcategory_id;

    try {
        const response = await this.$axios.get(`http://127.0.0.1:8000/api/products/${subcategory_id}`);
        console.log('API Response:', response.data);
        // Obrada podataka kada je status 200 OK
        this.products = response.data;
        console.log(this.products.length);
    } catch (error) {
        console.error('Error Products found:', error.message);
        console.error('Response status:', error.response.status);
        console.error('Response data:', error.response.data);

        // Obrada različitih statusa
        if (error.response.status === 404) {
            // Not Found - butik nije pronađen
            console.error('Products not found');
        } else if (error.response.status === 500) {
            // Internal Server Error - neka druga greška
            console.error('Internal Server Error');
        }
    }
},
getAbsoluteImagePath(imageName) {
      return `http://127.0.0.1:8000/images/${imageName}`;
    },
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    },
    }
}
</script>
