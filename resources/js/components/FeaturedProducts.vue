<template>
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1" v-for="product in featuredProducts">
                <router-link :to="{name:'thisProduct',params:{id:product.id,productName: removeSpace(product.name)}}">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" :src="getAbsoluteImagePath(product.boutique[0].name,product.image1)" alt="">
                        <!-- <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div> -->
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{ product.name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{ product.price }} KM</h5><h6 class="text-muted ml-2" v-if="product.old_price != 0"><del>{{ product.old_price }} KM</del></h6>
                        </div>
                        <!-- <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>(99)</small>
                        </div> -->
                    </div>
                </div>
            </router-link>
            </div>
        </div>
    </div>

    <!-- Products End -->
</template>

<script>

export default {

    props:{
        featuredProducts:{
            type:Array,
            required:true
        }
    },
    methods:{
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
