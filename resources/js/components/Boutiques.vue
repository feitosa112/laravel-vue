<template>
    <div>
      <div class="container-fluid">
        <div class="row">

            <div class="col-6 col-lg-3 col-sm-6" v-for="boutique in boutiques" :key="boutique.id">
                <router-link :to="{ name: 'boutique-page', params: { boutiqueName: boutique.name }}" style="text-decoration: none;">

            <div class="product-offer mb-30">
                <img :src="getAbsoluteImagePath(boutique.image)" alt="" style="border-radius: 5px;" class="img-fluid">
                    <!-- <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div> -->
                    <div class="card">
                        <h2 class="text-fluid text-center">{{ boutique.name }}</h2>
                        <a href="" class="badge badge-primary bg-sm"><small class="text-fluid">{{ boutique.address }}</small></a>
                    </div>
            </div>
          </router-link>

        </div>
        </div>
      </div>

    </div>
  </template>

  <script>
  export default {
    data() {
      return {

        boutiques: [],
      };
    },
    mounted() {
      this.fetchBoutiques();
    },
    methods: {
      async fetchBoutiques() {
        try {
          const response = await this.$axios.get('http://127.0.0.1:8000/allBoutiques');
          this.boutiques = response.data;
        } catch (error) {
          console.error('Error fetching boutiques', error);
        }
      },
      getAbsoluteImagePath(imageName) {
      return `http://127.0.0.1:8000/images/${imageName}`;
    }
  }
    }

  </script>
