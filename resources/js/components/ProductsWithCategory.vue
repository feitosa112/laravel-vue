<template>
   <h3 v-if="products.length === 0">Trenutno nema proizvoda za ovu kategoriju</h3>
   <div class="container-fluid" v-else>
    <div class="row">
            <div class="col-lg-3 col-6 col-md-6 col-sm-6" v-for="product in products">
                <div class="product-item bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" :src="getAbsoluteImagePath(product.image1)" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{ product.name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5 class="success">{{ product.price }}KM</h5><h6 class="danger text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <a href="" class="badge badge-warning badge-sm float-left me-2" style="text-decoration: none;"><p class="mt-2">Dodaj u korpu</p></a>
                        <a href="" class="badge badge-success badge-sm float-right ms-2" style="text-decoration: none;"><p class="mt-2">Naruci odmah</p></a>

                    </div>
                    <!-- <small>{{ boutique.name }}</small> -->
                    </div>
                </div>
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
            this.getProductsWithCategory();
            console.log('Mount end');

        },
        methods:{
            async getProductsWithCategory() {
        const category_id = this.$route.params.category_id;


        try {
            const response = await this.$axios.get(`http://127.0.0.1:8000/products/${category_id}`);
            console.log('API Response:', response.data);
            // Obrada podataka kada je status 200 OK
            this.products = response.data;
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
        }
        }
    }
    </script>

