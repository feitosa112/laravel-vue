<template>
 <!-- Shop Detail Start -->
 <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" v-for="product1 in product.boutique" :src="getAbsoluteImagePath(product1.name,product.image1)" alt="Trenutno nema slike">
                        </div>
                        <div class="carousel-item" v-if="product.image2 != null">
                            <img class="w-100 h-100" v-for="product1 in product.boutique"  :src="getAbsoluteImagePath(product1.name,product.image2)" alt="Trenutno nema slike">
                        </div>
                        <div class="carousel-item" v-if="product.image3 !=null">
                            <img class="w-100 h-100" v-for="product1 in product.boutique"  :src="getAbsoluteImagePath(product1.name,product.image3)" alt="Trenutno nema slike">
                        </div>

                    </div>
                    <a class="carousel-control-prev" v-if="product.image2 !=null || product.image3 != null" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" v-if="product.image2 !=null || product.image3 != null" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h1>{{ product.name }}</h1>

                    <div class="d-flex mb-3">

                        <small class="pt-1">({{ product.view }} Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ product.price }} KM</h3>


                        <form @submit.prevent="submitForm">

                            <div class="d-flex mb-3" v-if="product.size != null">
                                <strong class="text-dark mr-3">Sizes:</strong>

                                <div class="custom-control custom-radio custom-control-inline" v-for="(size,index) in product.size.split(',')">
                                    <input type="radio" class="custom-control-input" :id="'size-'+index" :name="'size-group'" v-model="selectedSize" :value="size">
                                    <label class="custom-control-label" :for="'size-'+index">{{ size }}</label>
                                </div>

                            </div>
                            <div class="d-flex mb-4" v-if="product.color != null">
                                <strong class="text-dark mr-3">Colors:</strong>

                                <div class="custom-control custom-radio custom-control-inline" v-for="(color, index) in product.color.split(',')">
                                    <input type="radio" class="custom-control-input" :id="'color-' + index" :name="'color-group'" v-model="selectedColor" :value="color">
                                    <label class="custom-control-label" :style="{color: color, backgroundColor: color === 'white' ? 'black' : '' }" :for="'color-' + index">{{ color }}</label>
                                </div>
                            </div>


                        <button class="btn btn-primary px-3" type="submit"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>

                        </form>
                        <div class="alert alert-success" v-if="productInCart">Proizvod je u korpi vec</div>

                        <div class="alert alert-info" v-if="message">
                        {{ message }}
                        </div>
                        <div class="alert alert-danger" v-if="error">
                            {{ error }}
                        </div>




                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <p class="mb-4">{{ product.description }}</p>

                        </div>

                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">1 review for "Product Name"</h4>
                                    <div class="media mb-4">
                                        <img src="" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <AllProductsPaginator></AllProductsPaginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->
</template>

<script>
    import {reactive} from 'vue';
    import AllProductsPaginator from './AllProductsPaginator.vue';

    export default {
        components:{AllProductsPaginator},
        data(){
            return {
                product:{},
                cart:[],
                productName:null,
                message:null,
                error:null,
                productInCart:false,
                apiUrl: window.apiUrl


            }
        },

        mounted(){
            this.getProduct();

        },
        methods:{
            async submitForm() {
            // Napravite objekat sa podacima koje želite poslati
            const formData = {
                id: this.product.id,

                boutiqueName:this.product.boutique[0].name,
                color: this.selectedColor,
                size: this.selectedSize,
                // Dodajte ostale podatke o proizvodu koji su vam potrebni
                // ...
            };

            // Napravite HTTP POST zahtev ka Laravel serveru
            try {
                const response = await axios.post(`${this.apiUrl}/cart/addToCart`, formData);
                // Obradite odgovor ako je potrebno
                console.log(response.data);
                this.cart = response.data
                this.message = 'Proizvod je dodat u korpu';
                this.error=null;



            } catch (error) {
                console.error('Došlo je do greške prilikom slanja forme:', error);
                this.error = "Popunite sva polja(size,color...)";
                if(error.response.status === 401){
                    this.error = "Proizvod je vec dodat u korpu"
                }
            }
        },

            async getProduct(){
                const productName = this.$route.params.productName;
                const id = this.$route.params.id;

                try {
                    const response = await this.$axios.get(`${this.apiUrl}/products/product/${id}/${productName}`);
                    console.log('API Response:', response.data);
                    this.product = response.data;
                    this.productName = response.data.name;
                    document.title = this.productName;

                }catch(error){
                    console.error('Error fetching product details:', error.message);
                    console.error('Response status:', error.response.status);
                    console.error('Response data:', error.response.data);

                    // Obrada različitih statusa
                    if (error.response.status === 404) {
                        // Not Found - butik nije pronađen
                        console.error('Product not found');
                    } else if (error.response.status === 500) {
                        // Internal Server Error - neka druga greška
                        console.error('Internal Server Error');
                    }
                }
            },

            getAbsoluteImagePath(boutiqueName,imageName) {
                return `/images/${boutiqueName}/${imageName}`;
    },
        },

        watch: {
        '$route': 'getProduct'
        },




    }
</script>
