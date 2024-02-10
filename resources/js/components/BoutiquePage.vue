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
            <div class="col-lg-3 col-6 col-md-6 col-sm-6" v-for="product in boutique.product">
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
                    <small>{{ boutique.name }}</small>
                    </div>
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
