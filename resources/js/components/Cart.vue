<template>
    <div class="container-fluid">
        <div class="row px-xl-5">
            <h3 class="text-center" v-if="cart.length <1">Vasa korpa je trenutno prazna</h3>
            <form action="" v-else>

            <div class="col-lg-8 col-sm-12 table-responsive mb-5" >

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
                                <td>
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" @click.prevent="minus(product)" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" :value="product.cart_quantity">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus" @click.prevent="plus(product)" >
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    </div>
                                </td>
                                <td>{{ product.size }}</td>
                                <td>{{ product.color }}</td>
                                <td>{{ product.boutiqueName }}</td>
                                <td>{{ (product.cart_quantity * product.price).toFixed(2) }}</td>
                                <td>
                                    <form @submit.prevent="deleteFromCart(product.productId,product.color,product.size)">


                                        <button type="submit" class="badge badge-danger bg-sm">Obrisi</button>
                                    </form>

                                </td>


                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="alert alert-success" v-if="deleteProductFromCart">{{ deleteProductFromCart }}</div>

            <div class="col-lg-8 col-sm-12">

                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>

                <div class="bg-light p-30 mb-5">
                    <input type="text" placeholder="Name" class="form-control">
                    <input type="text" placeholder="Surname" class="form-control mt-2">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>{{ totalSum.toFixed(2) }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">8</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>{{ (totalSum + 8).toFixed(2) }}</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
                </form>


        </div>
    </div>



    <form @submit.prevent="cartEmpty">
        <button class="btn btn-info" type="submit">Empty cart</button>
    </form>
    <div class="alert alert-success" v-if="emptyCartMsg">{{ emptyCartMsg }}</div>
</template>

<script>
// import CartLength from './CartLength.vue';

export default {
    // components:{CartLength},

    data(){
        return {
            cart:[],
            emptyCartMsg:null,
            deleteProductFromCart:null,
            totalSum:0,


        }
    },
    mounted(){
        this.getCart()
    },
//     provide() {
//     console.log('Providing cart:', this.cart);
//     return {
//         cart: this.cart
//     };
// },

    methods:{
        plus(product){
            product.cart_quantity +=1;
            product.cart_total = product.price*product.cart_quantity;
            this.updateTotalPrice();
        },
        minus(product){

            if(product.cart_quantity > 1){
                product.cart_quantity -= 1;
            product.cart_total = product.price*product.cart_quantity;
                this.updateTotalPrice();
            }
        },


        updateTotalPrice() {
        this.totalSum = this.cart.reduce((total, product) => {
            return total + product.price * product.cart_quantity;
        }, 0);
    },


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

        // if(response.data.length > 0){
        //     response.data.foreach(product => {
        //         this.price = product.price;
        //     })
        // }

        console.log('API Response:', response.data);
        this.cart = response.data.map(product => ({
    ...product,
    cart_quantity: 1,
    cart_total: product.price,

}));
this.updateTotalPrice();
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
},
async deleteFromCart(productId, color, size) {
    const requestDat = {
        productId:productId,
        color:color,
        size:size
    }
        try {

            const response =await this.$axios.post(`http://127.0.0.1:8000/api/cart/delete-product`,requestDat);
            if (response.status === 200) {
                this.deleteProductFromCart = response.data.message
                this.getCart(); // Ažuriranje korpe nakon brisanja proizvoda
            } else {
                console.error('Error deleting product from cart. Unexpected response status:', response.status);
            }
        } catch (error) {
            console.error('Error deleting product from cart:', error);
        }
    },
    },


}
</script>
