<template>

    <div class="container-fluid bg-dark mb-30" style="margin-top: -25px;">
        <div class="row px-xl-5">
            <Categories/>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <router-link :to="{name:'boutiques-page'}" class="nav-item nav-link">Butici</router-link>

                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="" class="nav-item nav-link">Contact</a>
                            <router-link :to="{name:'allProducts'}" class="nav-item nav-link">Svi proizvodi</router-link>

                        </div>
                        <div class="navbar-nav ml-auto py-0 d-lg-block">
                            <router-link class="btn px-0" :to="{name:'cartView'}">
                                <i class="fas fa-shopping-cart text-primary me-2"></i>
                                <span class="badge text-secondary border border-secondary" style="padding-bottom: 2px;">View Cart</span>
                            </router-link>
                            <!-- <a href="" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">2</span>
                            </a> -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import Categories from './Categories.vue';

export default {


  components: { Categories },
  data() {
    return {
      componentKey: 0,
    };
  },


};

</script>
