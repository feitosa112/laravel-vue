<!-- Ovde ispisujemo podatke za odredjeni butik -->

<template>
    <div class="container-fluid" >

         <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <router-link :to="{ name: 'addNewProduct' }" style="border-radius: 5px;" class="btn btn-info m-2" v-if="user && (user.email === boutique.email || user.email === admin_email)">Dodaj proizvod</router-link>
<button class="btn btn-info" style="border-radius: 5px;" v-if="user && (user.email === boutique.email || user.email === admin_email)">Broj posjeta:{{ boutique.view }}</button>

        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">

                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" :src="getAbsoluteImagePath(boutique.name,boutique.image)" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{ boutique.name }}</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{ boutique.description }}</p>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-lg-4 ">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" :src="getAbsoluteImagePath(boutique.name,boutique.image2)" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <!-- <h3 class="text-white mb-3">Special Offer</h3> -->
                        <!-- <a href="" class="btn btn-primary">Shop Now</a> -->
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" :src="getAbsoluteImagePath(boutique.name,boutique.image3)" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <!-- <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Shop Product Start -->
    <div class="col-lg-9 col-md-8">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-6 col-sm-12 col-md-12 text-left">
                <form action="" class="m-3">
                <div class="input-group position-relative">
                    <input v-model="searchQuery" @input="updateSuggestions" class="form-control" placeholder="Unesite termin pretrage"/>
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                        <i class="fa fa-search"></i>
                        </span>
                    </div>

                    <div class="suggestions position-absolute" v-if="suggestions.length > 0 && searchQuery !== ''">
                        <ul>
                            <li v-for="suggestion in suggestions" :key="suggestion.id" @click="selectSuggestion(suggestion)">
                                {{ suggestion.name }}
                            </li>
                        </ul>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div v-if="deleted" class="alert alert-success">{{ deletedProduct }}</div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6" v-for="product in filterProducts">

                <div class="product-item bg-light mb-4">

                    <router-link :to="{name:'thisProduct',params:{id:product.id,productName: removeSpace(product.name)}}">

                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" :src="getAbsoluteImagePath(boutique.name,product.image1)" alt="">
                        <i v-if="user" :class="{ 'fas fa-heart': isInFavorites(product.id), 'far fa-heart': !isInFavorites(product.id), 'text-danger': isInFavorites(product.id) }" @click="toggleFavorite(product)" style="position: absolute; top: 5px; right: 5px; font-size: 20px;"></i>
                    </div>

                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{ product.name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{ product.price }} KM</h5><h6 class="text-muted ml-2" v-if="product.old_price != 0.00"><del>{{ product.old_price }}</del></h6>
                        </div>
                    </div>
                    </router-link>

                            <div class="float-left">
                                <button class="badge badge-danger bg-sm me-1" @click="deleteProduct(product.id)" v-if="user && (user.email === boutique.email || user.email === admin_email)">Delete</button>
                               <router-link :to="{name:'editView',params:{id:product.id}}" class="badge badge-warning bg-sm ms-1" v-if="user && (user.email === boutique.email || user.email === admin_email)">Edit</router-link>
                            </div>





                        </div>

                    </div>




                </div>
            </div>
            <!-- Shop Product End -->
        </div>



  </template>

  <script>


  export default {


    data() {
      return {
        boutique: {},
        boutiqueName:null,
        user:window.user || null,
        searchQuery: '',
        suggestions: [],
        admin_email:'112kuzmanovic@gmail.com',
        deletedProduct:'Uspjesno ste obrisali proizvod',
        deleted:false,
        inFavorites: [],
        apiUrl: window.apiUrl


      };
    },
    mounted() {
        console.log('Mounted...');
      this.fetchBoutiqueDetails();
    },
    created(){
        if (this.user) {
            this.loadFavorites();
        }
    },

    computed:{
        filterProducts() {
        const query = this.searchQuery.toLowerCase();
        return this.boutique.product ? this.boutique.product.filter(product =>
          product.name.toLowerCase().startsWith(query)
        ) : [];
      }
    },
    methods: {
        deleteProduct(productId) {
            const id = productId;
            if (confirm('Are you sure you want to delete this product?')) {
                this.$axios.get(`${this.apiUrl}/products/delete-product/${id}`)
                    .then(response => {
                        // Ovdje možete dodati logiku nakon uspješnog brisanja proizvoda
                        console.log('Product deleted successfully:', response.data);

                        this.deleted = true;
                        this.fetchBoutiqueDetails();
                    })
                    .catch(error => {
                        // Ovdje možete obraditi greške prilikom brisanja proizvoda
                        console.error('Error deleting product:', error);
                    });
            }
        },
        filterProductsOnCurrentPage() {
  const query = this.searchQuery.toLowerCase();

  this.products = this.boutique.product.filter((product) =>
  product.name.toLowerCase().includes(query)
  )
        },


        updateSuggestions() {
        const query = this.searchQuery.toLowerCase();
        this.suggestions = this.boutique.product.filter((product) =>
          product.name.toLowerCase().includes(query)
        );
        this.filterProductsOnCurrentPage();
      },
      selectSuggestion(suggestion) {
        this.searchQuery = suggestion.name;
        this.suggestions = [];
      },

        async fetchBoutiqueDetails() {
    const boutiqueName = this.$route.params.boutiqueName;
    try {
        const response = await this.$axios.get(`${this.apiUrl}/${boutiqueName}`);
        console.log('API Response:', response.data);
        // Obrada podataka kada je status 200 OK
        this.boutique = response.data;
        this.boutiqueName = response.data.name
        document.title = this.boutiqueName;

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
getAbsoluteImagePath(boutiqueName,imageName) {
      return `/images/${boutiqueName}/${imageName}`;
    },
    // metoda za uklanjanje razmaka izmedju rijeci koju cemo iskoristii u url-u
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    },

    async loadFavorites() {
            try {
                const response = await axios.get(`${this.apiUrl}/products/all-fav`);
                this.inFavorites = response.data[1];
                console.log('MyFav:',response.data[1]);
            } catch (error) {
                console.error('Error loading favorites:', error);
            }
        },
        toggleFavorite(product) {
            if (this.isInFavorites(product.id)) {
                this.removeFromFavorites(product.id);
                // this.$emit('toggle-favorite', product.id);
            } else {
                this.addToFavorites(product.id);
            }
        },
        isInFavorites(productId) {
            return this.inFavorites.some(favorite => favorite.product_id === productId);
        },
        async addToFavorites(productId) {
            try {
                await axios.get(`${this.apiUrl}/product/add-to-fav/${productId}`);
                this.inFavorites.push({ product_id: productId });
            } catch (error) {
                console.error('Error adding to favorites:', error);
            }
        },
        async removeFromFavorites(productId) {
            try {
                await axios.get(`${this.apiUrl}/product/remove-fav/${productId}`);
                this.inFavorites = this.inFavorites.filter(favorite => favorite.product_id !== productId);
                this.$emit('remove-from-favorites', productId);
                console.log('Remove product kartica:',productId);
            } catch (productId) {
                console.error('Error removing from favorites(komponenta kartica):', productId);
            }
        }


    },

    provide(){
        return {
      cartItems: this.cartItems || [],
    };
    },

    watch:{
        '$route': 'fetchBoutiqueDetails',
        cartItems(newCartItems) {
      // Update the provide data when cartItems change
      this.$root.cartItems = newCartItems;
    },


    }


  };
  </script>

  <style scoped>
  .suggestions {
    background-color: white;
    border: 1px solid #ccc;
    max-height: 200px;
    overflow-y: auto;
    width: 100%;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
  }

  .suggestions ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }

  .suggestions li {
    padding: 8px;
    cursor: pointer;
    border-bottom: 1px solid #ccc;
  }

  .suggestions li:last-child {
    border-bottom: none;
  }
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
        /* line-height: 0.5; */
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
