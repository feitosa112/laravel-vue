<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <h1>Add new Boutique</h1>
            <div class="alert alert-success" v-if="boutiqueSave">{{ save_message }}</div>
        </div>

        <div class="col-8">
            <form @submit.prevent="saveBoutique" enctype="multipart/form-data">
                <input type="text" v-model="name" placeholder="Unesite naziv butika" class="form-control mb-1" required>
                <input type="text" v-model="address" placeholder="Unesite adresu butika" class="form-control mb-1" required>
                <input type="text" v-model="email" placeholder="Unesite email" class="form-control mb-1" required>
                <input type="text" v-model="phone" placeholder="Unesite telefon" class="form-control mb-1" required @input="validatePhone">
                <div v-if="phoneError" class="text-danger">{{ phoneError }}</div>
                <textarea name="" v-model="description" id="" cols="40" rows="5" required>Opis</textarea>
                <input type="file" @change="handleImageChange('image',$event)" name="image" class="form-control mb-1" required>
                <input type="file" @change="handleImageChange('image2',$event)" name="image2" class="form-control mb-1" required>
                <input type="file" @change="handleImageChange('image3',$event)" name="image3" class="form-control mb-1" required>

                <button type="submit" class="btn btn-info form-control">Save</button>


            </form>
        </div>
    </div>
</div>
</template>


<script>
    export default {
        data(){
            return {
                name:'',
                address:'',
                email:'',
                phone:'',
                description:'',
                image: null,
                image2: null,
                image3: null,
                save_message:'Uspjesno ste dodali novi butik',
                phoneError: '',
                apiUrl: window.apiUrl

            }
        },
        //METHODS START
        methods:{
            //metoda za cuvanje butika u bazi start
            async saveBoutique(){
                const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                const formData = {
                    name:this.name,
                    address:this.address,
                    email:this.email,
                    phone:this.phone,
                    description:this.description,
                    image:this.image,
                    image2:this.image2,
                    image3:this.image3,
                    boutiqueSave:false

                }

                try {
                    const response = await this.$axios.post(`${this.apiUrl}/admin/add-new-boutique`, formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
                });

                this.boutiqueSave=true;
                this.emptyForm();
                console.log('NewProduct:', response.data);
                }catch (error) {
    console.error('Došlo je do greške prilikom slanja forme:', formData);
    this.error = 'Popunite sva polja ';
  }
            },//metoda za cuvanje butika u bazi end



            //metoda za dodavanje slika start
            handleImageChange(inputName,event) {
            console.log('Event:', event);

            const file = event.target.files[0];
            console.log('File:', file);

            if (file) {

            this[inputName] = file;
            } else {

            this[inputName] = null;
            }
        },//metoda za dodavanje slika end


        //metoda za praznjenje forme nakon uspjesnog unosa start
        emptyForm(){
            this.name='',
            this.address='',
            this.email='',
            this.phone='',
            this.description='',
            this.image='',
            this.image1='',
            this.image2=''

        },//metoda za praznjenje forme nakon uspjesnog unosa end


        //metoda za validaciju broja start
        validatePhone() {

            const phoneRegex = /^(\+\d{1,3})?[-.\s]?(\d{9,10})$/;

            if (!phoneRegex.test(this.phone)) {
            this.phoneError = 'Invalid phone number format. Please use a valid format.';
            } else {
            this.phoneError = null;
            }
        },//metoda za validaciju broja end

        }//METHODS END

    }
</script>
