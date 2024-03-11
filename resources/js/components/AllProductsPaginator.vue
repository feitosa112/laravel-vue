<template>
<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Svi proizvodi</span></h2>

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

      <div class="row" style="height: 35wh;">
        <div class="col-6 col-md-6 col-sm-6 col-lg-3  mb-2" v-for="product in paginatedProducts" :key="product.id">
          <div class="card" id="card" style="max-width: 300px; box-shadow: 5px 5px 5px gray">
            <router-link :to="{ name: 'thisProduct', params: { id: product.id, productName: removeSpace(product.name) }}" style="text-decoration: none;">
              <div class="card-header">
                <img class="img-fluid w-100" :src="getAbsoluteImagePath(product.boutique[0].name, product.image1)" alt=""/>
                <div class="product-img position-relative overflow-hidden"></div>
              </div>

              <div class="card-body" style="padding: 0">
                <h3 class="card-title naslov">{{ product.name }}</h3>
                <h4
                  class="card-subtitle mb-2 float-start naslov"
                  style="color: #65B741"
                >
                  {{ product.price }}KM
                </h4>
                <small class="card-subtitle mb-2 float-right podnaslov" v-if="product.old_price != 0" style="color: #B80000">
                  <del>{{ product.old_price }} KM</del>
                </small>
              </div>
            </router-link>
            <div class="card-footer" style="padding: 2px">
              <router-link :to="{ name: 'boutique-page', params: { boutiqueName: removeSpace(boutique.name) }}" v-for="boutique in product.boutique" :key="boutique.id">
                <button style="border-radius: 5px" class="btn btn-info btn-sm float-end mobile-button">
                  Posjeti butik: <b>{{ boutique.name }}</b>
                </button>
              </router-link>
            </div>
          </div>
        </div>
      </div>

    <div class="pagination justify-content-center" v-if="products.length > 0">
      <button @click="prevPage" class="btn btn-outline-info me-2" >Prethodna</button>
      <a style="text-decoration: none;" class="btn btn-secondary me-2">{{ currentPage }}/{{ totalPages }}</a>
      <button @click="nextPage" class="btn btn-outline-info me-2" >Sljedeća</button>
    </div>
  </div>
</template>

<script>
    export default {
        data(){
            return {
                products: [],
                all:[],
                searchQuery: '',
                suggestions: [],
                perPage: '',
                currentPage: 1,
                totalPages: 1,
            }
        },

        mounted(){
            this.title = 'Butici Banja Luka';
            this.allProducts();
        },


        methods:{
            filterProductsOnCurrentPage() {
  const query = this.searchQuery.toLowerCase();
  this.products = this.all.filter((product) =>
  product.name.toLowerCase().includes(query)
  );
  this.totalPages = Math.ceil(this.products.length / this.perPage);
  if (this.currentPage > this.totalPages) {
    this.currentPage = this.totalPages;
  }
},

async allProducts() {
      try {
        const page = this.currentPage;

        const response = await this.$axios.get(
          `http://127.0.0.1:8000/api/products/all-products`
        );
        console.log('Response dataaaa...',response.data);
        console.log('Ovo je...',response.data[0].data);
        console.log('Per page:',response.data[0].per_page);
        this.products = response.data[2];
        this.perPage = response.data[0].per_page;
        this.all = response.data[2];
        console.log('ProductsLength',this.all.length);
        this.totalPages = Math.ceil(this.all.length / this.perPage);
        console.log('Total pages:',this.totalPages);
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },

    getAbsoluteImagePath(boutiqueName, imageName) {
        return `http://127.0.0.1:8000/images/${boutiqueName}/${imageName}`;
      },
      removeSpace(name) {
        return name.replace(/\s+/g, '-');
      },
      updateSuggestions() {
        const query = this.searchQuery.toLowerCase();
        this.suggestions = this.all.filter((product) =>
          product.name.toLowerCase().includes(query)
        );
        this.filterProductsOnCurrentPage();
      },
      selectSuggestion(suggestion) {
        this.searchQuery = suggestion.name;
        this.suggestions = [];
      },

      prevPage() {
      if (this.currentPage > 1) {
        this.currentPage-=1;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage+=1;
      }
    }
        },

        computed: {
      filterProducts() {
        const query = this.searchQuery.toLowerCase();
        return this.all ? this.all.filter(product =>
          product.name.toLowerCase().startsWith(query)
        ) : [];
      },
      paginatedProducts() {
      const startIndex = (this.currentPage-1) * this.perPage;
      const endIndex = startIndex + this.perPage;
      return this.filterProducts.slice(startIndex, endIndex);
    },
    },
    }
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

  .pagination {
  margin-top: 10px;
}

.pagination button {
  margin: 0 5px;
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 5px;
}
.card {
  transition: transform 0.2s;
}

.card:hover {
  transform: scale(1.05);
}

  </style>
