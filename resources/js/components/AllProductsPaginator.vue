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

      <Kartica :products="paginatedProducts"></Kartica>


    <div class="pagination justify-content-center" v-if="products.length > 0">
      <button @click="prevPage" class="btn btn-outline-info me-2" >Prethodna</button>
      <a style="text-decoration: none;" class="btn btn-secondary me-2">{{ currentPage }}/{{ totalPages }}</a>
      <button @click="nextPage" class="btn btn-outline-info me-2" >Sljedeća</button>
    </div>
  </div>
</template>

<script>
import Kartica from './Kartica.vue'
    export default {
        components:{Kartica},
        data(){
            return {
                products: [],
                all:[],
                searchQuery: '',
                suggestions: [],
                perPage: '',
                currentPage: 1,
                totalPages: 1,
                apiUrl: window.apiUrl

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
          `${this.apiUrl}/products/all-products`
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
