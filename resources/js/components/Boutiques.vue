<!-- U ovom templateu se nalazi $boutiques(niz butika) koji dobijamo putem API,pomocu v-for prolazimo kroz svaki objekat posebno i ispisujemo podatke.
    U router linku koristimo metodu  removeSpace(name) pomocu koje brisemo razmak izmedju rijeci u url-u -->

<template>
    <div>
      <div class="container-fluid">
        <div class="row">
            <div class="col-1 col-lg-2 col-sm-1 d-none d-sm-block">
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>

            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-5 col-lg-3 col-sm-5" v-for="boutique in boutiques" :key="boutique.id" style="border-right: 1px dotted gray;">
                        <router-link :to="{ name: 'boutique-page', params: { boutiqueName: removeSpace(boutique.name)}}" style="text-decoration: none;">

                        <div class="product-offer mb-30">
                            <img :src="getAbsoluteImagePath(boutique.image)" alt="" style="border-radius: 5px;" class="img-fluid">
                    <div class="offer-text">
                        <!-- <h6 class="text-white text-uppercase">Save 20%</h6> -->
                        <!-- <h5 class="text-white mb-3" v-if="boutique.id === 1">Veliko snizenje !!!</h5> -->
                        <!-- <a href="" class="btn btn-primary">Shop Now</a> -->
                    </div>
                            <div class="card">
                                <h2 class="text-fluid text-center">{{ boutique.name }}</h2>
                                <a href="" class="badge badge-primary bg-sm"><small class="text-fluid">{{ boutique.address }}</small></a>
                            </div>
                        </div>
                        </router-link>

                    </div>
                </div>

            </div>
            <div class="col-1 col-lg-2 col-sm-1 d-none d-sm-block">
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>
                <p>dddd</p>

            </div>

        </div>
      </div>

    </div>

  </template>

<!-- U scriptu imamo metodu fetchBoutiques u kojoj dobijamo niz objekata(butika) u varijablu boutiques,
pomocu API koji je izgradjen u laravelu(BoutiquesControllor.php) -->
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
