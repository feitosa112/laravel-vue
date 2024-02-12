<template>
<podnavbar/>
<router-view></router-view>

</template>


<script>

export default {

    data(){
        return {
            user:[]
        }
    },
    mounted(){
        this.loggedUser()
    },
  methods: {
    async loggedUser() {
      try {
        const response = await this.$axios.get('http://127.0.0.1:8000/user/isLoged');
        this.user = response.data;
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    }
  },

  provide: async function () {
    await this.loggedUser();
    return {
            user:this.user
        }
  }


};

</script>
