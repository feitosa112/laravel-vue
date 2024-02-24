<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active" v-for="subCat in subCategory">
        <a class="nav-link" href="#">{{ subCat.name }}</a>
      </li>
    </ul>
  </div>
</nav>
</template>

<script>
export default {
    props:{
        subCategory:{
            type:Array,
            required:true
        }
    }
}
</script>
