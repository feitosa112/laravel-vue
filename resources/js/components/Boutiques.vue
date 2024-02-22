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
                    <div class="col-6 col-md-6 col-sm-6 col-lg-4 mb-2" v-for="boutique in boutiques" :key="boutique.id" style="border-right: 1px dotted gray;">
                            <div class="card" id="card" style="border-radius: 5%;box-shadow:0px 0px 5px rgba(0,0,0,0.5);">
                                <div class="card-header">
                                    <img :src="getAbsoluteImagePath(boutique.image)" alt="" style="border-radius: 5px;" class="img-fluid">
                                </div>

                                <div class="card-body naslov">
                                    <h4 class="text-fluid text-center">{{ boutique.name }}</h4>
                                </div>

                                <div class="card-footer podnaslov">
                                    <p class="float-start">
                                        <small>{{ boutique.address }}</small>
                                    </p>

                                    <p class="float-end podnaslov">
                                        <small v-if="boutique.phone != null">{{ boutique.phone }}</small>
                                    </p>
                                        <router-link :to="{ name: 'boutique-page', params: { boutiqueName: removeSpace(boutique.name)}}" style="text-decoration: none;">

                                            <button class="btn btn-primary form-control" id="butik-submit" style="border-radius: 5px;">Pogledaj</button>
                                        </router-link>

                                </div>
                            </div>


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
    document.title="Butici Banja Luka"
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
