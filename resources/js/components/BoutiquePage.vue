<!-- Ovde ispisujemo podatke za odredjeni butik -->

<template>
    <div class="container-fluid" >

        <div class="row" style="background-color: #FFD333;">
            <div class="col-4" style="border-right: 1px dotted gray;"></div>
            <div class="col-4" style="color: #343a40;" >
                <h1>{{ user }}</h1>
                <h1 class="text-center" style="letter-spacing: 5px;">{{ boutique.name }}</h1>
                <p class="text-center">{{ boutique.address }}</p>
                <p class="text-center">{{ boutique.email }}</p>
                <p class="text-center">{{ boutique.phone }}</p>

            </div>
            <div class="col-4" style="border-left: 1px dotted gray;">

            </div>
        </div>

        <div class="row" style="height: 35wh;">
                <div class="col-lg-3 col-4 col-md-4 col-sm-4"  v-for="product in boutique.product">
                    <router-link :to="{ name: 'thisProduct', params: { id: product.id,productName:removeSpace(product.name) }}" style="text-decoration: none;">

                <div class="product-item bg-light" id="products" style="border: 2px solid rgb(173, 167, 167);padding: 0;">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" :src="getAbsoluteImagePath(product.image1)" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4" style="margin-top: -15px;">
                        <a class="h6 text-decoration-none text-truncate" href=""><h4>{{ product.name }}</h4></a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5 class="success">{{ product.price }}KM</h5><h6 class="danger text-muted ml-2" v-if="product.old_price != null"><del class="danger">{{ product.old_price }} KM</del></h6>
                        </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <a href="" class="badge badge-warning badge-sm float-left me-1" style="text-decoration: none;"><p class="mt-2">Dodaj u korpu</p></a>
                        <a href="" class="badge badge-success badge-sm float-right ms-1" style="text-decoration: none;"><p class="mt-2">Naruci odmah</p></a>

                    </div>
                    <small style="color: #343a40;">{{ boutique.name }}</small>
                    </div>
                </div>
                 </router-link>

            </div>

        </div>
    </div>


  </template>

  <script>
  export default {
    inject:['user'],

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
        const response = await this.$axios.get(`http://127.0.0.1:8000/api/${boutiqueName}`);
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
// postavljena apsolutna putanja za slike
getAbsoluteImagePath(imageName) {
      return `http://127.0.0.1:8000/images/${imageName}`;
    },
    // metoda za uklanjanje razmaka izmedju rijeci koju cemo iskoristii u url-u
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    }
    },
  };
  </script>

  <style scoped>
  @media (max-width:556px) {
    h1{
        font-size: 11px;
    }
    h4 {
        font-size: 8px;
    }

    a.badge {
        width: 50%;
        height: 20px;
    }
    p{
        font-size: 5px;
        padding: 0;
        margin-left: -3px;
        line-height: 0.5;
    }
    small {
        font-size: 7px;
    }
    img {
        height: 25%;
    }
  }
h1{
    letter-spacing: 2px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight: 900;

};
p{
    letter-spacing: 2px;
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight: 900;
    margin-top: -20px;
    line-height: 0.5;
}

</style>
