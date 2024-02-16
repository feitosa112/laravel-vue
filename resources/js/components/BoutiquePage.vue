<!-- Ovde ispisujemo podatke za odredjeni butik -->

<template>
    <div class="container-fluid" >

        <div class="row" style="background-color: #FFD333;">
            <div class="col-4" style="border-right: 1px dotted gray;">
            </div>
            <div class="col-4" style="color: #343a40;" >

                <h1 class="text-center" style="letter-spacing: 5px;">{{ boutique.name }}</h1>
                <p class="text-center">{{ boutique.address }}</p>
                <p class="text-center">{{ boutique.email }}</p>
                <p class="text-center">{{ boutique.phone }}</p>

            </div>
            <div class="col-4" style="border-left: 1px dotted gray;">

            </div>
        </div>

        <div class="row" style="height: 35wh;">
                <div class="col-6 col-md-6 col-sm-6 col-lg-4 mb-2"  v-for="product in boutique.product">
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

addToCart(product) {
    let cartItems = JSON.parse(localStorage.getItem('cart')) || [];

    const existingProductIndex = cartItems.findIndex(item => item.id === product.id);

    if (existingProductIndex !== -1) {
        cartItems[existingProductIndex].quantity += 1;
    } else {
        cartItems.push({ id: product.id, name: product.name, quantity: 1, price: product.price });
    }

    localStorage.setItem('cart', JSON.stringify(cartItems));
    this.productInCart = cartItems;

    this.$root.$emit('localStorageUpdated');

    console.log('Product added to the cart:', product);
    console.log('Updated cartItems:', cartItems);
},




// postavljena apsolutna putanja za slike
getAbsoluteImagePath(imageName) {
      return `http://127.0.0.1:8000/images/${imageName}`;
    },
    // metoda za uklanjanje razmaka izmedju rijeci koju cemo iskoristii u url-u
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    },


    },

    provide(){
        return {
      cartItems: this.cartItems || [],
    };
    },

    watch:{
        cartItems(newCartItems) {
      // Update the provide data when cartItems change
      this.$root.cartItems = newCartItems;
    },
    }


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
