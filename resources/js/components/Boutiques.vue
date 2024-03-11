<!-- U ovom templateu se nalazi $boutiques(niz butika) koji dobijamo putem API,pomocu v-for prolazimo kroz svaki objekat posebno i ispisujemo podatke.
    U router linku koristimo metodu  removeSpace(name) pomocu koje brisemo razmak izmedju rijeci u url-u -->

<template>

      <div class="container-fluid">
        <Search></Search>
        <div class="row">

            <Najprodavaniji/>
            <div class="col-sm-12 col-md-12 col-lg-8 d-flex flex-wrap">
                <div class="row">
                    <div class="col-5 col-md-5 col-sm-5 col-sm-ms-2 col-lg-3 mb-2 " v-for="boutique in boutiques" :key="boutique.id">
                        <div class="card" style="border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1);">
                            <img :src="getAbsoluteImagePath(boutique.name, boutique.image)" class="card-img-top" alt="Slika butika" style="object-fit: cover; height: 170px; border-radius: 10px 10px 0 0;">

                            <h5 class="card-title text-center">{{ boutique.name }}</h5>
                            <p class="card-text text-center" style="font-size: 9px;">{{ boutique.address }}</p>

                        <div class="card-footer">
                        <router-link :to="{ name: 'boutique-page', params: { boutiqueName: removeSpace(boutique.name)}}" class="btn btn-primary btn-block" style="border-radius: 0 0 10px 10px;">Pogledaj</router-link>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <Najnoviji/>
        </div>



      </div>
      <AllProductsPaginator></AllProductsPaginator>
      <CategoriesHome></CategoriesHome>
     <FeaturedProducts :featuredProducts="featuredProducts"></FeaturedProducts>

  </template>

<!-- U scriptu imamo metodu fetchBoutiques u kojoj dobijamo niz objekata(butika) u varijablu boutiques,
pomocu API koji je izgradjen u laravelu(BoutiquesControllor.php) -->
  <script>
  import Najprodavaniji from "./NajprodavanijiProizvodi.vue";
  import Najnoviji from "./NajnovijiProizvodi.vue";
  import FeaturedProducts from "./FeaturedProducts.vue";
  import CategoriesHome from './Categories-home.vue'

  import AllProductsPaginator from './AllProductsPaginator.vue'

  export default {
    components:{Najprodavaniji,Najnoviji,CategoriesHome,FeaturedProducts,AllProductsPaginator},
    data() {
      return {

        boutiques: [],
        featuredProducts:[],


      };
    },



    mounted() {
      this.fetchBoutiques();
      document.title = "Butici Banja Luka"
    },
    methods: {


      async fetchBoutiques() {
        try {
            const response = await this.$axios.get('http://127.0.0.1:8000/api/allBoutiques');
            this.boutiques = response.data.allBoutiques;
            this.featuredProducts = response.data.featuredProducts;

            console.log('FeaturedProducts:',this.featuredProducts);
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
.card {
  transition: transform 0.2s;
}

.card:hover {
  transform: scale(1.05);
}
</style>
