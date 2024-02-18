<template>
    <div v-for="product in cart" >
        {{ product.productName }}
        {{ product.boutiqueName }}

    </div>

    <form @submit.prevent="cartEmpty">
        <button class="btn btn-info" type="submit">Empty cart</button>
    </form>
    <div class="alert alert-insfo" v-if="emptyCartMsg">{{ emptyCartMsg }}</div>
</template>

<script>

export default {
    data(){
        return {
            cart:[],
            emptyCartMsg:null
        }
    },
    mounted(){
        this.getCart()
    },
    methods:{
        async getCart(){
            try {
                    const response = await this.$axios.get(`http://127.0.0.1:8000/api/cart/cart-view`);
                    console.log('API Response:', response.data);
                    this.cart = response.data;
                }catch(error){
                    console.error('Error cart view:', error.message);
                    console.error('Response status:', error.response.status);
                    console.error('Response data:', error.response.data);

                    // Obrada različitih statusa
                    if (error.response.status === 404) {

                        console.error('Cart not found');
                    } else if (error.response.status === 500) {
                        // Internal Server Error - neka druga greška
                        console.error('Internal Server Error');
                    }
                }
        },

        async cartEmpty(){
            try {
                const response = await axios.post(`http://127.0.0.1:8000/api/cart/empty-cart`);
                this.emptyCartMsg = response.data.message
                this.getCart();
            }catch(error){
                console.log(error);
            }
        }
    }
}
</script>
