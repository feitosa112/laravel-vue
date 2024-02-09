<template>
<div class="row">
    <h1>{{boutique.name }}</h1>
    <p>{{ boutique.address }}</p>
    <p v-for="product in boutique.product">{{ product.name }}</p>
</div>
</template>

<script>
export default {
    data(){
        return{

            // products:[],
            // currentBoutique:null,
            boutique:[]
        }
    },
    mounted(){
        console.log('Component is mounted. Fetching data...');
        this.fetchBoutique();
    },
    methods:{
        async fetchBoutique() {
            try {
                const boutiqueId = this.$route.params.boutiqueId
                const response = await axios.get(`http://127.0.0.1:8000/${boutiqueId}`);
                console.log('API Response:', response.data);
                this.boutique = response.data;
            } catch (error) {
                console.error('Error fetching boutiques:', error);
            }
        }
    }

    }

</script>
