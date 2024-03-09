<template>
    <div class="row">
        <div class="col-lg-6 offset-lg-3 col-6 col-sm-12 col-md-12 text-left">
          <form action="" class="m-3">
            <div class="input-group position-relative">
              <input
                v-model="searchQuery"
                @input="updateSuggestions"
                class="form-control"
                placeholder="Unesite termin pretrage"
              />

              <div class="input-group-append">
                <span class="input-group-text bg-transparent text-primary">
                  <i class="fa fa-search"></i>
                </span>
              </div>

              <div
                class="suggestions position-absolute"
                v-if="suggestions.length > 0 && searchQuery !== ''"
              >
                <ul>
                  <li
                    v-for="suggestion in suggestions"
                    :key="suggestion.id"
                    @click="selectSuggestion(suggestion)"
                  >
                    {{ suggestion.name }}
                  </li>
                </ul>
              </div>
            </div>
          </form>
        </div>
      </div>


</template>

<script>

    export default {
        props:['boutiques'],
        data(){
            return {
                searchTerm:'',
            }
        }
    }
</script>
