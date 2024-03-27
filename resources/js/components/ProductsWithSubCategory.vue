<template>
    <div :key="$route.fullPath">


        <div class="container-fluid">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item active" v-for="cat in allCat">
                                <router-link :to="{name:'getProductsWithCategory',params:{category_id:cat.id}}" class="nav-link" href="#"><small>{{ cat.name }}</small></router-link>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <h3 v-if="products.length === 0">Trenutno nema proizvoda za ovu kategoriju</h3>
            <div class="row" v-else>
                <Kartica :products="products"></Kartica>

            </div>
        </div>
    </div>
</template>

<script>
import Kartica from './Kartica.vue';

export default {
    components:{Kartica},
    data() {
        return {
            products: [],
            allCat: [],
            apiUrl: window.apiUrl

        };
    },

    mounted() {
        console.log('Mount start');
        this.getProductsWithSubCategory();
        console.log('Mount end');
       this.getAllCategories();
    },
    watch: {
        '$route.params.subcategory_id': function (newVal, oldVal) {
            this.getProductsWithSubCategory();
        }
    },
    methods: {

        beforeRouteUpdate(to, from, next) {
            this.getProductsWithSubCategory();
            next();
        },
        async getProductsWithSubCategory() {
            const subcategory_id = this.$route.params.subcategory_id;

            try {
                const response = await this.$axios.get(`${this.apiUrl}/products/sub-category/${subcategory_id}/detail`);
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

        async getAllCategories() {
        try {
          const odg = await this.$axios.get(`${this.apiUrl}/boutique/allCategories`);
          this.allCat = odg.data.allCategories;


          console.log('AllCat:',this.allCat);

        } catch (error) {
          console.error('Error categories', error);
        }
      },
        getAbsoluteImagePath(boutiqueName, imageName) {
            return `http://127.0.0.1:8000/images/${boutiqueName}/${imageName}`;
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
};
</script>
