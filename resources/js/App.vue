<template>
    <div>
      <podnavbar />
      <router-view></router-view>
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

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
