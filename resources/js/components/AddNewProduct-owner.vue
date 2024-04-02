<!-- Komponenta za dodavanje novog proizvoda.Samo ulogovani korinsik i vlasnik butika moze dodavati proizvode u svoj butik -->
<template>
    <div class="container text-center">
      <h2>Dodaj novi proizvod u bazu</h2>
        <div class="alert alert-success" v-if="addProduct">
            <p>Uspjesno ste dodali proizvod!</p>

        </div>


      <form @submit.prevent="saveProduct" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-4">
            <!-- Prva kolona -->
            <div class="mb-3">
              <label for="productName" class="form-label">Naziv proizvoda:</label>
              <input v-model="productName" type="text" class="form-control" id="productName" required>
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Kategorija:</label>
              <select v-model="selectedCategory" v-if="categories.length>0" @change="loadSubcategories" class="form-select" id="category" required>
                <option value="" disabled selected>Izaberi kategoriju</option>
                <option v-for="category in categories" v-if="categories != null" :key="category.id" :value="category.id">{{ category.name }}</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="subcategory" class="form-label">Podkategorija:</label>
              <select v-model="selectedSubcategory" class="form-select" id="subcategory" required>
                <option value="" disabled selected>Izaberi podkategoriju</option>
                <option v-for="subcategory in subcategories" v-if="subcategories.length>0" :key="subcategory.id" :value="subcategory.id">{{ subcategory.name }}</option>
              </select>
            </div>

            <div class="mb-3">
          <label for="size" class="form-label">Unesite velicine</label>
          <input type="text" v-model="inputSize" id="size" class="form-control" placeholder="Unesite velicine koje imate u ponudi, između svake stavite zarez" required>
        </div>


          </div>

          <div class="col-md-4">
            <!-- Druga kolona -->
            <input type="hidden" v-if="boutique.length >0" v-model="boutique[0].id" name="boutique_id">

            <div class="mb-3">
              <label for="image1" class="form-label">Izaberi sliku 1</label>
              <input type="file" @change="handleImageChange('image1',$event)" name="image1" class="form-control">
            </div>

            <div class="mb-3">
              <label for="image2" class="form-label">Izaberi sliku 2</label>
              <input type="file" @change="handleImageChange('image2',$event)" name="image2" class="form-control">
            </div>

            <div class="mb-3">
              <label for="image3" class="form-label">Izaberi sliku 3</label>
              <input type="file" @change="handleImageChange('image3',$event)" name="image3" class="form-control">
            </div>


          </div>

          <div class="col-md-4">
            <!-- Treća kolona -->
            <div class="mb-3">
              <label for="price" class="form-label">Unesi cijenu</label>
              <input v-model="price" type="number" class="form-control">
            </div>

            <div class="mb-3">
              <label for="old_price" class="form-label">Unesi staru cijenu</label>
              <input v-model="old_price" type="number" class="form-control">
            </div>

            <div class="mb-2">
              <label for="opis" class="form-label">Opis</label>
              <textarea v-model="opis" id="opis" cols="40" rows="3" class="form-control"></textarea>
            </div>



            <!-- <div class="mb-3">
              <label for="color" class="form-label">Izaberi boju:</label>
              <select v-model="selectedColor" id="color" class="form-select" required>
                <option value="" disabled selected>Izaberi boju</option>
                <option v-for="color in colors" :style="{ backgroundColor: color }" :value="color">{{ color }}</option>
              </select>
            </div> -->
          </div>
        </div>
        <div class="row">
            <div class="mb-3" style="display: flex;">
                <div v-for="(color, index) in colors" :key="index" style="margin-right: 10px;">
    <input
        type="checkbox"
        :id="'color' + index"
        :checked="isColorSelected(color)"
        @change="handleColorChange(color)"
        class="me-1"
    />
    <label :for="'color' + index" :style="{ backgroundColor: color, padding: '5px', cursor: 'pointer' }">
        {{ color }}
    </label>
</div>
            </div>
        </div>



        <button type="submit" class="btn btn-primary form-control">Dodaj proizvod</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {

        selectedCategory: '',
        selectedSubcategory: '',
        selectedColors:[],
        categories: [],
        subcategories: [],
        user: window.user || null,
        boutique: [],
        boutique_name:'',
        colors: ['black', 'white', 'yellow', 'red', 'orange', 'blue', 'green', 'gray', 'brown', 'violet', 'pink', 'gold'],
        productName: '',
       price: '',
       old_price: '',
       opis: '',
       inputSize: '',
       image1: null,
       image2: null,
       image3: null,
       error: '',
       addProduct:false,
       selectedColor: '',
       apiUrl: window.apiUrl




      };
    },
    mounted() {
        if(this.categories != null){
            this.getAllCategories();

        }
      this.getBoutique();
    },
    methods: {
        async saveProduct() {
            console.log(this.productName,this.selectedCategory,this.selectedSubcategory,this.boutique[0].id,this.price,this.old_price,this.selectedColor,this.inputSize,this.image1,this.image2,this.image3,this.boutique_name);
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            const formData = {
      name: this.productName,
      category_id: this.selectedCategory,
      subcategory_id: this.selectedSubcategory,
      boutique_id: this.boutique[0].id,
      price: this.price,
      old_price: this.old_price,
      description: this.opis,
      color: this.selectedColors.join(','),
      size: this.inputSize,
      image1: this.image1,
      image2: this.image2,
      image3: this.image3,
      boutique_name:this.boutique[0].name,
        }
        console.log('name:',formData.name);
  try {

    const response = await this.$axios.post(`${this.apiUrl}/products/add-new-product`, formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
                });

    this.addProduct=true;
    this.emptyForm();
    console.log('NewProduct:', response.data);
  } catch (error) {
    console.error('Došlo je do greške prilikom slanja forme:', formData);
    this.error = 'Popunite sva polja (size, color...)';
  }
},

isColorSelected(color) {
        return this.selectedColors.includes(color);
    },
    handleColorChange(color) {
        if (this.selectedColors.includes(color)) {
            // Ako je boja već izabrana, uklonite je iz niza
            this.selectedColors = this.selectedColors.filter(c => c !== color);
        } else {
            // Ako boja nije izabrana, dodajte je u niz
            this.selectedColors.push(color);
        }
    },
    // Metoda za prikaz svih kategorija da bi se mogla odabrati kategorija za proizvod koji se unosi
      async getAllCategories() {
        try {

          const odg = await this.$axios.get(`${this.apiUrl}/boutique/allCategories`);
          this.categories = odg.data.allCategories;
          console.log('AllCat:', this.categories);
          this.loadSubcategories();
        } catch (error) {
          console.error('Error categories', error);
        }
      },
    //   Metoda za ucitavanje podkategorija nza izabranu kategoriju
      async loadSubcategories() {
    if (this.selectedCategory) {
        const category = this.selectedCategory;
        try {

            const response = await this.$axios.get(`${this.apiUrl}/category/sub-cat/${category}`);
            this.subcategories = response.data;
            console.log('Subcategories:', response.data);
        } catch (error) {
            console.error('Error loading subcategories:', error);
        }
    }
},

      async getBoutique() {

        if (this.user === null) {
        console.error('Korisnik nije prijavljen.');
        return;
    }else{

        console.log(this.user.id);
        const id = this.user.id;
        try {

          const response = await this.$axios.get(`${this.apiUrl}/user/email/${id}`);
          this.boutique = response.data;
          console.log('Boutique:', response.data);
        } catch (error) {
          console.error('Error', error);
        }
    }
      },

      handleImageChange(inputName,event) {
  console.log('Event:', event);
  const file = event.target.files[0];
  console.log('File:', file);
  if (file) {
    // Postavljanje vrednosti u odgovarajući data property na osnovu imena inputa
    this[inputName] = file;
  } else {
    // Ako korisnik otkaže izbor slike, postavljamo vrednost na null
    this[inputName] = null;
  }
},
// Nakon sto se sacuva proizvod polja za unos se prazne
emptyForm(){
    this.productName='',
    this.price='',
    this.old_price='',
    this.description='',
    this.size='',
    this.image1='',
    this.image2='',
    this.image3='',
    this.categories=[],
    this.subcategories=[]

}

},

  };
  </script>
