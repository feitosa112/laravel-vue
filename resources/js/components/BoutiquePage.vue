<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12" style="background-color: #FFD333; color: #343a40;">

                <h1 class="text-center text-fluid">{{ boutique.name }}</h1>
                <p class="text-center">{{ boutique.address }}</p>
                <p class="text-center">{{ boutique.email }}</p>
                <p class="text-center">{{ boutique.phone }}</p>

            </div>
        </div>

        <div class="row">
            <div class="col-6 col-lg-3 col-sm-6" v-for="product in boutique.product">
                <div class="product-offer mb-30">
                    <img :src="getAbsoluteImagePath(product.image)" alt="Za ovaj proizvod trenudtno ne postoji slika" class="img-fluid">
                </div>
            </div>
        </div>
    </div>


  </template>

  <script>
  export default {
    data() {
      return {
        boutique: {},
      };
    },
    mounted() {
        console.log('Mounted...');
      this.fetchBoutiqueDetails();
    },
    methods: {
        async fetchBoutiqueDetails() {
    const boutiqueName = this.$route.params.boutiqueName;
    try {
        const response = await this.$axios.get(`http://127.0.0.1:8000/${boutiqueName}`);
        console.log('API Response:', response.data);
        // Obrada podataka kada je status 200 OK
        this.boutique = response.data;
    } catch (error) {
        console.error('Error fetching boutique details:', error.message);
        console.error('Response status:', error.response.status);
        console.error('Response data:', error.response.data);

        // Obrada različitih statusa
        if (error.response.status === 404) {
            // Not Found - butik nije pronađen
            console.error('Boutique not found');
        } else if (error.response.status === 500) {
            // Internal Server Error - neka druga greška
            console.error('Internal Server Error');
        }
    }
},

getAbsoluteImagePath(imageName) {
      return `http://127.0.0.1:8000/images/${imageName}`;
    }
    },
  };
  </script>

  <style scoped>
h1{
    letter-spacing: 2px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight: 900;
};
p{
    letter-spacing: 2px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight: 900;
}
</style>
