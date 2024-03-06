<template>
    <div class="col-2 col-sm-12 col-lg-2 col-md-12 d-none d-lg-block">
                <small>Najprodavaniji proizvodi</small>

                <div class="row mb-2" v-if="theBestSellingsProduct.length>0" v-for="product in theBestSellingsProduct" :key="product.product && product.product.id">
  <router-link :to="{name:'thisProduct',params:{id:product.product && product.product.id, productName: removeSpace(product.product.name)}}">
    <div class="col-3">
      <img :src="getAbsoluteImagePath((product.product && product.product.boutique[0] && product.product.boutique[0].name) || '', product.product && product.product.image1)" style="height: 30px;" alt="">
    </div>
    <div class="col-8">
      <small class="float-start" style="margin-left: 8px; text-decoration: none; color: brown;font-size: 8px;">{{ product.product && product.product.name }}</small>
      <a href="" class="badge badge-success bg-sm float-end" style="font-size: 8px;">{{ product.product && product.product.price }}</a>

    </div>
  </router-link>
</div>
            </div>
</template>

<script>
    export default {
        data(){
            return {
                theBestSellingsProduct:[],
            }
        },
        mounted(){
            this.theBestSellingProducts();
        },
        methods:{
            async theBestSellingProducts() {
        try {
            const response = await this.$axios.get('http://127.0.0.1:8000/api/products/theBestSellingsProduct');
            this.theBestSellingsProduct = response.data;
            console.log('theBestSellingsProducts:',response.data)
            console.log('theBestSellingsProducts:',this.theBestSellingProducts)



        } catch (error) {
          console.error('Error fetching theBestSellingsProduct', error);
        }
      },
      getAbsoluteImagePath(boutiqueName,imageName) {
      return `http://127.0.0.1:8000/images/${boutiqueName}/${imageName}`;
    },
    // metoda za uklanjanje razmaka izmedju rijeci koju cemo iskoristii u url-u
    removeSpace(name){
        return name.replace(/\s+/g, "-");
    },
        }
    }
</script>
