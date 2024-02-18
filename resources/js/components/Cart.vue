<template>
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <h3 class="text-center" v-if="cart.length <1">Vasa korpa je trenutno prazna</h3>

                <form action="" v-else>
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Boutique</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                        </thead>

                        <tbody class="align-middle">
                            <tr v-for="product in cart">
                                <td>{{ product.productName }}</td>
                                <td>{{ product.price }}</td>
                                <td></td>
                                <td>{{ product.size }}</td>
                                <td>{{ product.color }}</td>
                                <td>{{ product.boutiqueName }}</td>
                                <td>{{ product.price }}</td>
                                <td>Remove</td>

                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>



    <form @submit.prevent="cartEmpty">
        <button class="btn btn-info" type="submit">Empty cart</button>
    </form>
    <div class="alert alert-insfo" v-if="emptyCartMsg">{{ emptyCartMsg }}</div>
</template>

<script>
import CartLength from './CartLength.vue';
export default {
    components:{CartLength},

    data(){
        return {
            cart:[],
            emptyCartMsg:null,

        }
    },
    mounted(){
        this.getCart()
    },
    provide() {
    console.log('Providing cart:', this.cart);
    return {
        cart: this.cart
    };
},
    methods:{
        async cartEmpty() {
    try {
        const response = await axios.post(`http://127.0.0.1:8000/api/cart/empty-cart`);
        if (response.status === 200) {
            this.emptyCartMsg = response.data.message;
            // Dodajte zakašnjenje ovdje ako je potrebno
            this.getCart();
        } else {
            console.error('Error emptying cart. Unexpected response status:', response.status);
        }
    } catch (error) {
        console.error('Error emptying cart:', error);
    }
},

async getCart() {
    try {
        const response = await this.$axios.get(`http://127.0.0.1:8000/api/cart/cart-view`);
        console.log('API Response:', response.data);
        this.cart = response.data;
    } catch (error) {
        console.error('Error cart view:', error.message);
        console.error('Response status:', error.response?.status);
        console.error('Response data:', error.response?.data);

        // Obrada različitih statusa
        if (error.response?.status === 404) {
            console.error('Cart not found');
        } else if (error.response?.status === 500) {
            // Internal Server Error - neka druga greška
            console.error('Internal Server Error');
        }
    }
}
    },


}
</script>
