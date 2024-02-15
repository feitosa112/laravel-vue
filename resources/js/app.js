import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';


import {createRouter,createWebHistory} from 'vue-router';
import App from "./App.vue"

import Boutiques from "./components/Boutiques.vue"
import BoutiquePage from "./components/BoutiquePage.vue";
import PodNavbar from "./components/PodNavbar.vue";
import ProductsWithSubCategory from "./components/ProductsWithSubCategory.vue";
import ProductsWithCategory from "./components/ProductsWithCategory.vue";
import ThisProduct from "./components/ThisProduct.vue";
import Cart from "./components/Cart.vue"

const app = createApp(App)
const router = createRouter({
    history:createWebHistory(),
    mode:'history',
    routes:[
        {path:'/',component:Boutiques,name:'boutiques-page'},
        {path:'/products/:subcategory_id',component:ProductsWithSubCategory,name:'getProductsWithSubCategory'},
        {path:'/products/:category_id',component:ProductsWithCategory,name:'getProductsWithCategory'},
        {path:'/product/:id/:productName',component:ThisProduct,name:'thisProduct'},
        {path:'/:boutiqueName',component:BoutiquePage,name:'boutique-page'},
        {path:'/cart/:id',component:Cart,name:'addToCart'},
        {path:'/cart',component:Cart,name:'cart'}





    ]
});
app.component('boutiques',Boutiques)
app.component('boutique-page',BoutiquePage)
app.component('podnavbar',PodNavbar)
app.component('ProductsWithSubCategory',ProductsWithSubCategory)
app.component('ProductsWithCategory',ProductsWithCategory)



app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app')
