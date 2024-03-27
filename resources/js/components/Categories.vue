<!-- U ovoj komponenti imamo kategorije koje smo dobili putem apija(CategoryControllor.php) iz baze.Takodje za svaku kategoriju ispisujemo potkategorije
Ovu komponentu ukljucujemo u PodNavbar.vue komponentu -->

<template>

<div class="col-lg-3 d-block  d-lg-block">
    <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
        <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>


        <i class="fa fa-angle-down text-dark"></i>
    </a>
    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
        <div class="navbar-nav w-100">
            <div class="nav-item dropdown dropright"  v-for="category in allCategories">

                <router-link :to="{name:'getProductsWithCategory',params:{category_id:category.id}}" exact v-if="category.with_sub_category.length === 0" class="nav-link dropdown-toggle" data-toggle="dropdown" @click.prevent>{{ category.name }}</router-link>
                <a href="#" v-else  class="nav-link dropdown-toggle" data-toggle="dropdown">{{ category.name }} <i class="fa fa-angle-right float-right mt-1"></i></a>
                <div class="dropdown-menu position-absolute rounded-0 border-0 m-0"  >

                    <router-link :to="{name:'getProductsWithSubCategory',params:{subcategory_id:subCategory.id}}" :key="subCategory.id" exact v-for="subCategory in category.with_sub_category" class="dropdown-item" @click.prevent>{{ subCategory.name }}</router-link>

                </div>


        </div>
    </div>
    </nav>
</div>

</template>

<script>


export default {
    data(){
        return {
            allCategories:[],
            apiUrl: window.apiUrl

        }
    },

    mounted() {
        console.log('Mounted categories start...');
      this.getAllCategories();
      console.log('Mounted categories end...');
    },
    methods: {
      async getAllCategories() {
        try {
          const odg = await this.$axios.get(`${this.apiUrl}/boutique/allCategories`);
          this.allCategories = odg.data.allCategories;
          console.log(this.allCategories);

        } catch (error) {
          console.error('Error categories', error);
        }
      },

  }
}
</script>
