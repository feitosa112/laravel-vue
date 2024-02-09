<template>
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-3 col-sm-6 col-6 mb-2" v-for="boutique in boutiques" :key="boutique.name">
            <div class="product-offer mb-30" >
                <img :src="getImagePath(boutique.image)"  alt="" class="img-fluid" loading="eager" style="width: auto;height: auto;">
                    <div class="offer-text">
                        <h1 class="text-white mb-3">{{ boutique.name }}</h1>
                    </div>
            </div>
            <div class="card-body">
                <a class="badge badge-primary bg-sm mt-2"><p>Lokacija:{{ boutique.address }}</p></a>

            </div>
            <div class="card-footer">
                <a href="" class="badge badge-primary bg-sm mt-2">
                <p>Email:{{ boutique.email }}</p>
                </a>
                <a href="" class="badge badge-primary bg-sm mt-2">
                <p>Telefon:{{ boutique.phone }}</p>

                </a>
        <router-link :to="{name:'boutique-page',params:{boutiqueId:boutique.id}}">Posjeti butik</router-link>



            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            boutiques: [],
        };
    },
    mounted() {
        console.log('Component is mounted. Fetching data...');
        this.fetchBoutiques();
    },
    methods: {
        async fetchBoutiques() {
            try {

                const response = await axios.get('http://127.0.0.1:8000/allBoutiques');
                console.log('API Response:', response.data);
                this.boutiques = response.data;
            } catch (error) {
                console.error('Error fetching boutiques:', error);
            }
        },
        getImagePath(imageName) {
            return `http://127.0.0.1:8000/images/${imageName}`;
    }
    },
};

</script>
