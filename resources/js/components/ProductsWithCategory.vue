<template>
    <SubcategoryInCategory :subCategory="subCategory"></SubcategoryInCategory>
   <h3 v-if="products.length === 0">Trenutno nema proizvoda za ovu kategoriju</h3>

   <div class="container-fluid" v-else>
    <Kartica :products="products"></Kartica>

   </div>
</template>

    <script>
    import SubcategoryInCategory from './SubCategoryInCategory.vue';
    import Kartica from './Kartica.vue';
    export default {
        components :{SubcategoryInCategory,Kartica},
        data(){
            return {
                products:[],
                subCategory:[],
                apiUrl: window.apiUrl

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
            const response = await this.$axios.get(`${this.apiUrl}/products/category/${category_id}`);
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
    getAbsoluteImagePath(boutiqueName,imageName) {
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
    }
    </script>

