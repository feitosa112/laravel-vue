<template>
<div class="container-fluid">
    <h1 class="text-center naslov">Svi proizvodi</h1>
    <!-- {{ products }} -->
    <div class="row" style="height: 35wh;">
                <div class="col-6 col-md-6 col-sm-6 col-lg-3 mb-2"  v-for="product in products">
                        <div class="card" id="card" style="max-width: 300px;box-shadow:5px 5px 5px gray">
                    <router-link :to="{name: 'thisProduct', params: { id: product.id,productName:removeSpace(product.name)}}" style="text-decoration: none;">

                            <div class="card-header">
                                <img class="img-fluid w-100" :src="getAbsoluteImagePath(product.boutique[0].name,product.image1)" alt="">
                                <div class="product-img position-relative overflow-hidden">

                                </div>
                            </div>

                        <div class="card-body" style="padding: 0">
                            <h3 class="card-title naslov">{{ product.name }}</h3>
                            <h4 class="card-subtitle mb-2 float-start naslov" style="color: #65B741">{{ product.price }}KM</h4>
                            <small class="card-subtitle mb-2 float-right podnaslov" v-if="product.old_price !=0" style="color: #B80000"><del>{{product.old_price}} KM</del></small>
                        </div>
                    </router-link>
                        <div class="card-footer" style="padding: 2px">

                            <router-link :to="{name:'boutique-page',params: { boutiqueName: removeSpace(boutique.name)}}"  v-for="boutique in product.boutique" >
                                <button style="border-radius: 5px" class="btn btn-info btn-sm float-end mobile-button">Posjeti butik: <b>{{ boutique.name }}</b> </button>

                            </router-link>

                        </div>

                        </div>


                </div>
        </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            products:[],
        }
    },
    mounted(){
        this.title = "Butici Banja Luka",
        this.allProducts();
    },
    methods: {
        async allProducts(){
            try {
                const response =await this.$axios.get('http://127.0.0.1:8000/api/products/all-products');
                this.products = response.data
            }catch (error) {
          console.error('Error fetching products:', error);
        }
        },
        getAbsoluteImagePath(boutiqueName,imageName) {
      return `http://127.0.0.1:8000/images/${boutiqueName}/${imageName}`;
    },
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    }
    },

}
</script>
