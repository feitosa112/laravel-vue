<!-- U ovom templateu se nalazi $boutiques(niz butika) koji dobijamo putem API,pomocu v-for prolazimo kroz svaki objekat posebno i ispisujemo podatke.
    U router linku koristimo metodu  removeSpace(name) pomocu koje brisemo razmak izmedju rijeci u url-u -->

<template>

      <div class="container-fluid">
        <div class="row">
    <div class="col-lg-4 col-6 text-left">
      <form action="" class="m-3">
        <div class="input-group position-relative">
          <input v-model="searchQuery" @input="updateSuggestions" class="form-control" placeholder="Unesite termin pretrage" />

          <div class="input-group-append">
            <span class="input-group-text bg-transparent text-primary">
              <i class="fa fa-search"></i>
            </span>
          </div>

          <!-- Postavite sugestije ispod polja pretrage -->
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
        <div class="row">

            <Najprodavaniji/>
            <div class="col-sm-6 col-md-6 col-lg-8">
                <div class="row">
                    <div class="col-6 col-md-6 col-sm-6 col-lg-3 mb-2" v-for="boutique in filteredBoutiques" :key="boutique.id">
                        <div class="card mb-2" id="card" style="border-radius: 5%;box-shadow:0px 0px 5px rgba(0,0,0,0.5);">
                        <img :src="getAbsoluteImagePath(boutique.name,boutique.image)" class="card-img-top" alt="Slika" style="object-fit: cover; height: 60%;">
                            <div class="card-body naslov" style="margin-top: -20px;">
                                <h4 class="card-title text-center">{{ boutique.name }}</h4>
                                <small class="text-muted float-end">{{ boutique.address }}</small>
                                <router-link :to="{ name: 'boutique-page', params: { boutiqueName: removeSpace(boutique.name)}}" style="text-decoration: none;">
                                    <button class="btn btn-primary form-control" id="butik-submit" style="border-radius: 5px;">Pogledaj</button>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <Najnoviji/>
        </div>



      </div>
      <CategoriesHome></CategoriesHome>
     <FeaturedProducts :featuredProducts="filteredFeaturedProducts" :searchQuery="searchQuery"></FeaturedProducts>

  </template>

<!-- U scriptu imamo metodu fetchBoutiques u kojoj dobijamo niz objekata(butika) u varijablu boutiques,
pomocu API koji je izgradjen u laravelu(BoutiquesControllor.php) -->
  <script>
  import Najprodavaniji from "./NajprodavanijiProizvodi.vue";
  import Najnoviji from "./NajnovijiProizvodi.vue";
  import FeaturedProducts from "./FeaturedProducts.vue";
  import CategoriesHome from './Categories-home.vue'
  import Search from "./Search.vue";

  export default {
    components:{Najprodavaniji,Najnoviji,CategoriesHome,FeaturedProducts,Search},
    data() {
      return {

        boutiques: [],
        featuredProducts:[],
        searchQuery: '',
        suggestions: []

      };
    },
    computed:{

        filteredBoutiques() {
      const query = this.searchQuery.toLowerCase();
      return this.boutiques.filter(boutique =>
        boutique.name.toLowerCase().startsWith(query) ||
        boutique.address.toLowerCase().startsWith(query)
      );
    },

    filteredFeaturedProducts() {
      // Prilagodite ovu logiku filtriranja prema vašim potrebama
      // Ovde koristimo samo searchQuery kao primer
      const query = this.searchQuery.toLowerCase();
      return this.featuredProducts.filter(product =>
        product.name.toLowerCase().startsWith(query) || product.subcategory[0].name.toLowerCase().startsWith(query)
      );
    }

    },


    mounted() {
      this.fetchBoutiques();
      document.title = "Butici Banja Luka"
    },
    methods: {
        updateSuggestions() {
      const query = this.searchQuery.toLowerCase();
      this.suggestions = this.boutiques.filter(boutique =>
        boutique.name.toLowerCase().includes(query)
      );
    },
    selectSuggestion(suggestion) {
      this.searchQuery = suggestion.name;
      this.suggestions = [];
    },

      async fetchBoutiques() {
        try {
            const response = await this.$axios.get('http://127.0.0.1:8000/api/allBoutiques');
            this.boutiques = response.data.allBoutiques;
            this.featuredProducts = response.data.featuredProducts;


        } catch (error) {
          console.error('Error fetching boutiques', error);
        }
      },
    //   metoda u kojoj postavljamo apsolutnu putanju za slike
      getAbsoluteImagePath(boutiqueName,imageName) {
      return `http://127.0.0.1:8000/images/${boutiqueName}/${imageName}`;
    },
    // metoda koju koristimo da neutralisemo razmak izmedju rijeci u url-u
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    }
  }
    }

  </script>


<style scoped>
  /* Stilizujte sugestije */
  .suggestions {
    background-color: white;
    border: 1px solid #ccc;
    max-height: 200px;
    overflow-y: auto;
    width: 100%;
    position: absolute;
    top: 100%; /* Postavite sugestije ispod polja pretrage */
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
</style>
