import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';


import {createRouter,createWebHistory} from 'vue-router';
import App from "./App.vue"

import Boutiques from "./components/Boutiques.vue"
import BoutiquePage from "./components/BoutiquePage.vue";
// import PodNavbar from "./components/PodNavbar.vue";
import ProductsWithSubCategory from "./components/ProductsWithSubCategory.vue";
import ProductsWithCategory from "./components/ProductsWithCategory.vue";
import ThisProduct from "./components/ThisProduct.vue";
import Cart from "./components/Cart.vue"
import AllProducts from './components/AllProducts.vue'
import AddNewProduct from './components/AddNewProduct-owner.vue'
import AddNewBoutique from './components/Admin_add_new_boutique.vue'
import MyFavorites from './components/MyFavorites.vue';
import ContactView from './components/ContactView.vue';
import EditView from './components/EditView.vue'

window.apiUrl = '/api'
const app = createApp(App)

const router = createRouter({
    history:createWebHistory(),
    mode:'history',
    base:'/',
    routes:[
        {path:'/',component:Boutiques,name:'boutiques-page'},
        { path: '/products/sub-category/:subcategory_id/detail', component: ProductsWithSubCategory, name: 'getProductsWithSubCategory'},
        {path:'/products/category/:category_id',component:ProductsWithCategory,name:'getProductsWithCategory'},
        {path:'/product/:id/:productName',component:ThisProduct,name:'thisProduct'},
        {path:'/:boutiqueName',component:BoutiquePage,name:'boutique-page'},
        {path:'/cart/cart-view',component:Cart,name:'cartView'},
        {path:'/products/all-products',component:AllProducts,name:'allProducts'},
        {path:'/owner/add-new-product',component:AddNewProduct,name:'addNewProduct'},
        {path:'/admin/add-new-boutique',component:AddNewBoutique,name:'addNewBoutique'},
        {path:'/user/my-favorite',component:MyFavorites,name:'myFavorite'},
        {path:'/user/contact-view',component:ContactView,name:'contactView'},
        {path:'/admin/edit-view/:id',component:EditView,name:'editView'},


    ]
});
app.component('boutiques',Boutiques)
app.component('boutique-page',BoutiquePage)
// app.component('podnavbar',PodNavbar)
app.component('ProductsWithSubCategory',ProductsWithSubCategory)
app.component('ProductsWithCategory',ProductsWithCategory)




app.config.globalProperties.$axios = axios;
app.use(router)

app.mount('#app')
