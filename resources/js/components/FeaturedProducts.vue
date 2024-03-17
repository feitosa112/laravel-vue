<template>
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
        <Kartica :products="featuredProducts"></Kartica>

    </div>

    <!-- Products End -->
</template>

<script>
import Kartica from './Kartica.vue';
export default {
    components:{Kartica},
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
