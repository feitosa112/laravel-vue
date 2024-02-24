<template>
    <SubcategoryInCategory :subCategory="subCategory"></SubcategoryInCategory>
   <h3 v-if="products.length === 0">Trenutno nema proizvoda za ovu kategoriju</h3>

   <div class="container-fluid" v-else>
    <div class="row">
            <div class="col-4 col-md-4 col-sm-4 col-lg-3 mb-2" v-for="product in products">
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
    import SubcategoryInCategory from './SubCategoryInCategory.vue'
    export default {
        components :{SubcategoryInCategory},
        data(){
            return {
                products:[],
                subCategory:[],
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
            const response = await this.$axios.get(`http://127.0.0.1:8000/api/products/category/${category_id}`);
            console.log('API Response:', response.data);
            // Obrada podataka kada je status 200 OK
            this.products = response.data.products;
            this.subCategory = response.data.subCategory;

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
        removeSpace(name) {
    // Provera da li je name definisan i da li ima metodu replace
    if (name && typeof name.replace === 'function') {
        return name.replace(/\s+/g, "-");
    } else {
        // Ako name nije definisan ili nema metodu replace, vratite neku podrazumevanu vrednost ili prazan string
        return "";
    }
},
        }
    }
    </script>

