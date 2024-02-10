<template>

<div class="col-lg-3 d-none d-lg-block">
    <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
        <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
        <i class="fa fa-angle-down text-dark"></i>
    </a>
    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
        <div class="navbar-nav w-100">
            <div class="nav-item dropdown dropright"  v-for="category in allCategories">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ category.name }} <i class="fa fa-angle-right float-right mt-1"></i></a>
                <div class="dropdown-menu position-absolute rounded-0 border-0 m-0"  v-for="subCategory in category.with_sub_category">

                    <a href="" class="dropdown-item">{{ subCategory.name }}</a>

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
            allCategories:[]
        }
    },
    mounted() {
        console.log('Mounted start...');
      this.getAllCategories();
      console.log('Mounted end...');
    },
    methods: {
      async getAllCategories() {
        try {
          const odg = await this.$axios.get('http://127.0.0.1:8000/boutique/allCategories');
          this.allCategories = odg.data;
          console.log(this.allCategories);
        } catch (error) {
          console.error('Error categories', error);
        }
      },

  }
}
</script>
