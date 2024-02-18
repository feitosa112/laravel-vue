<template>
    <div>
      <podnavbar />
      <router-view></router-view>
      <Footer></Footer>
    </div>
  </template>

<script>
import Footer from './components/Footer.vue';
import podnavbar from "./components/PodNavbar.vue"


export default {
  components: { Footer, podnavbar },

  // ...
};
</script>
