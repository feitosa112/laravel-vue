<template>
    <p v-for="product in products" :key="product.id">{{ product.name }}</p>
</template>

<script>
    export default {
        data() {
            return {
                products:[]
            }
        },
        mounted(){
            this.addToCart();
        },
        methods: {
            async addToCart(){
                try {
                    const id = this.$route.params.id;
            const response =await this.$axios.get(`http://127.0.0.1:8000/api/cart/${id}`);
            this.products = response.data
            console.log('Korpa test:',response.data);
                } catch (error) {
          console.error('Error fetching boutiques', error);
        }

        },
        }
    }
</script>
