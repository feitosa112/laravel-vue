<template>
<div class="container-fluid">
    <div class="row">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Kontaktirajte nas</span></h2>
        <div class="alert alert-success" v-if="msgSent">{{ alertMsg }}</div>
    </div>
    <div class="row">
    <div class="col-md-6 offset-md-3">
        <form @submit.prevent="sendMsg" class="d-flex flex-column align-items-center">
            <textarea name="" v-model="message" class="form-control" id="" cols="15" rows="5"></textarea>
            <button class="btn btn-info form-control mt-2" type="submit">Posalji poruku</button>
        </form>
    </div>
</div>
</div>
</template>

<script>
    export default {
        data(){
            return {
                message:'',
                apiUrl: window.apiUrl,
                msgSent:false,
                alertMsg:''

            }
        },

        methods:{
            async sendMsg(){
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            const formData = {
                message:this.message
            }

            if(!window.user){
                window.location.href = '/login';
            }else{

            try {
                const response = await this.$axios.post(`${this.apiUrl}/user/contact-message`, formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
                });
                console.log('Poruka:',response.data);
                this.msgSent = true;
                this.message='';
                this.alertMsg = response.data.message;

            }catch (error) {
                console.error('Došlo je do greške prilikom slanja poruke:', error);

  }
}

            }
        }
    }
</script>
