<!-- U ovom templateu se nalazi $boutiques(niz butika) koji dobijamo putem API,pomocu v-for prolazimo kroz svaki objekat posebno i ispisujemo podatke.
    U router linku koristimo metodu  removeSpace(name) pomocu koje brisemo razmak izmedju rijeci u url-u -->

<template>
    <div>
      <div class="container-fluid">
        <div class="row">
            <Najprodavaniji/>
            <div class="col-sm-6 col-md-6 col-lg-8">
                <div class="row">
                    <div class="col-6 col-md-6 col-sm-6 col-lg-3 mb-2" v-for="boutique in boutiques" :key="boutique.id">
                <div class="card mb-2" id="card" style="border-radius: 5%;box-shadow:0px 0px 5px rgba(0,0,0,0.5);">
                    <img :src="getAbsoluteImagePath(boutique.image)" class="card-img-top" alt="Slika" style="object-fit: cover; height: 60%;">
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

        <Categories/>

      </div>
    </div>
  </template>

<!-- U scriptu imamo metodu fetchBoutiques u kojoj dobijamo niz objekata(butika) u varijablu boutiques,
pomocu API koji je izgradjen u laravelu(BoutiquesControllor.php) -->
  <script>
  import Najprodavaniji from "./NajprodavanijiProizvodi.vue";
  import Najnoviji from "./NajnovijiProizvodi.vue";
  import Categories from "./Categories-home.vue"
  export default {
    components:{Najprodavaniji,Najnoviji,Categories},
    data() {
      return {

        boutiques: [],

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
            this.boutiques = response.data;

        } catch (error) {
          console.error('Error fetching boutiques', error);
        }
      },
    //   metoda u kojoj postavljamo apsolutnu putanju za slike
      getAbsoluteImagePath(imageName) {
      return `http://127.0.0.1:8000/images/${imageName}`;
    },
    // metoda koju koristimo da neutralisemo razmak izmedju rijeci u url-u
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    }
  }
    }

  </script>
