import './bootstrap';
import { createApp } from 'vue';
import {createRouter,createWebHistory} from 'vue-router';
import App from "./App.vue"

import Boutiques from "./components/Boutiques.vue"
import BoutiquePage from "./components/BoutiquePage.vue"

const app = createApp(App)
const router = createRouter({
    history:createWebHistory(),
    routes:[
        {path:'/boutique-page/:boutiqueId',component:BoutiquePage,name:'boutique-page'}
    ]
});
app.component('boutiques',Boutiques)
app.component('boutique-page',BoutiquePage)
app.use(router)
app.mount('#app')
