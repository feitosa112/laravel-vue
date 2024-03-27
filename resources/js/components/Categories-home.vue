<template>
    <!-- Categories Start -->
    <div class="container-fluid pt-5">

        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3">


            <div class="col-lg-4 col-md-4 col-sm-4" v-for="category in allCat">
             <input type="hidden" name="id" :value="category.id">

            <router-link :to="{name:'getProductsWithCategory',params:{category_id:category.id}}">


                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="" :src="getAbsoluteImagePath(category.image)" alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>{{ category.name }}</h6>
                            <small class="text-body">{{ getProductCount(category.id) }} Proizvoda</small>
                        </div>
                    </div>

            </router-link>

            </div>

        </div>
    </div>
    <!-- Categories End -->
</template>

<script>

export default {
    data(){
        return {
            allCat:[],
            productsInCategory:[],
            apiUrl: window.apiUrl

        }
    },
    mounted() {
        console.log('Mounted cat-home start...');
      this.getAllCategories();
      console.log('Mounted cat-home end...');
    },

  methods:{
    async getAllCategories() {
        try {
          const odg = await this.$axios.get(`${this.apiUrl}/boutique/allCategories`);
          this.allCat = odg.data.allCategories;
          this.productsInCategory = odg.data.productsInCategory;

          console.log('AllCat:',this.allCat);

        } catch (error) {
          console.error('Error categories', error);
        }
      },
      getProductCount(categoryId) {
        const productsForCategory = this.productsInCategory.filter(product => product.category_id === categoryId);
             return productsForCategory.length;




    },
    getAbsoluteImagePath(imageName) {
      return `http://127.0.0.1:8000/images/${imageName}`;
    },
    // metoda za uklanjanje razmaka izmedju rijeci koju cemo iskoristii u url-u
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    },
  }
}
</script>
