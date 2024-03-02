<template>
    <div class="container text-center">
      <h2>Dodaj novi proizvod u bazu</h2>

      <form @submit.prevent="" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-4">
            <!-- Prva kolona -->
            <div class="mb-3">
              <label for="productName" class="form-label">Naziv proizvoda:</label>
              <input v-model="productName" type="text" class="form-control" id="productName" required>
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Kategorija:</label>
              <select v-model="selectedCategory" @change="loadSubcategories" class="form-select" id="category" required>
                <option value="" disabled selected>Izaberi kategoriju</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="subcategory" class="form-label">Podkategorija:</label>
              <select v-model="selectedSubcategory" class="form-select" id="subcategory" required>
                <option value="" disabled selected>Izaberi podkategoriju</option>
                <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">{{ subcategory.name }}</option>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <!-- Druga kolona -->
            <input type="hidden" :value="user.email" name="email">
            <input type="HIDDEN" :value="boutique[0].id" name="email">

            <div class="mb-3">
              <label for="image1" class="form-label">Izaberi sliku 1</label>
              <input type="file" name="image1" class="form-control">
            </div>

            <div class="mb-3">
              <label for="image2" class="form-label">Izaberi sliku 2</label>
              <input type="file" name="image2" class="form-control">
            </div>

            <div class="mb-3">
              <label for="image3" class="form-label">Izaberi sliku 3</label>
              <input type="file" name="image3" class="form-control">
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
                <textarea name="" id="" cols="30" rows="10"></textarea>
            </div>
          </div>

          <div class="mb-3">
        <label for="color" class="form-label">Izaberi boju:</label>
        <sketch-picker v-model="selectedColor" />
      </div>
        </div>

        <button type="submit" class="btn btn-primary form-control">Dodaj proizvod</button>
      </form>
    </div>
  </template>


<script>
import { Sketch } from 'vue-color';
    export default {
        components:{'sketch-picker':Sketch},
        data(){
            return {
                productName:'',
                selectedCategory:'',
                selectedSubcategory:'',
                categories:[],
                subcategories:[],
                user:window.user || null,
                boutique:[],
                selectedColor: '#ffffff',
            }
        },
        mounted(){
            this.getAllCategories();
            this.getBoutique();

        },

        methods:{

            async getAllCategories() {
        try {
          const odg = await this.$axios.get('http://127.0.0.1:8000/api/boutique/allCategories');
          this.categories = odg.data.allCategories;


          console.log('AllCat:',this.categories);
          this.loadSubcategories();

        } catch (error) {
          console.error('Error categories', error);
        }
      },

         async loadSubcategories() {
                const category =this.selectedCategory;
        try{


            const response = await this.$axios.get(`http://127.0.0.1:8000/api/category/sub-cat/${category}`);
            this.subcategories=response.data;
            console.log('Subcategories:',response.data)
        } catch (error) {
          console.error('Error categories', error);
        }
    },

        async getBoutique(){
        const id = this.user.id;
        try {
            const response = await this.$axios.get(`http://127.0.0.1:8000/api/user/email/${id}`);
            this.boutique = response.data;
            console.log('Boutique:',response.data);
        }catch (error) {
          console.error('Error', error);
        }
    }




        }
    }
</script>
