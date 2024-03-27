<template>
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">My Favorites</span></h2>

        <Kartica :products="products" ></Kartica>

    </div>
</template>

<script>
import Kartica from './Kartica.vue'

    export default {
        components:{Kartica},
        data(){
            return {
                products:[],
                inFavorites:[],
                apiUrl: window.apiUrl

            }
        },
        mounted(){
            this.myFavorites();
        },

        methods:{
            async myFavorites(){
                try {
                    const response = await axios.get(`${this.apiUrl}/products/all-fav`);
                    this.products = response.data[0];
                    this.inFavorites = response.data[1];

                    console.log('My favorites:',response.data);
                }catch (error) {
                    console.error('Error loading favorites:', error);
                }
            },


    }
        }

</script>
