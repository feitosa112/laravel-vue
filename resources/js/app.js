import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';

import {createRouter,createWebHistory} from 'vue-router';
import App from "./App.vue"

import Boutiques from "./components/Boutiques.vue"
import BoutiquePage from "./components/BoutiquePage.vue";
import PodNavbar from "./components/PodNavbar.vue";


const app = createApp(App)
const router = createRouter({
    history:createWebHistory(),
    routes:[
        {path:'/',component:Boutiques,name:'boutiques-page'},
        {path:'/:boutiqueName',component:BoutiquePage,name:'boutique-page'},

    ]
});
app.component('boutiques',Boutiques)
app.component('boutique-page',BoutiquePage)
app.component('podnavbar',PodNavbar)


app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app')
