<template>
  <v-navigation-drawer v-model="drawer" fixed app clipped  class="drawer-style" id="style-1">
    
    <v-flex xs8  offset-md2>

        <v-select
            v-model="category_value"
            :items="categories"
            attach
            chips
            label="Select Category"
          ></v-select>
          
        <v-select
            v-model="country_value"
            :items="countries"
            attach
            chips
            label="Select Countries"
          ></v-select>

        <v-select
            v-model="language_value"
            :items="languages"
            attach
            chips
            label="Select Language"
          ></v-select>
        
        <v-text-field
            label="Keyword"
            v-model="query"
          ></v-text-field>
    </v-flex>
              
    <v-flex xs8 offset-md4>
        <v-btn @click="filterResults()" depressed color="primary">Search</v-btn>
    </v-flex>
  
  </v-navigation-drawer>
</template>


<script>

import axios from 'axios'

export default {

   props: {
      api_key: String,
      drawer: Boolean

    },

  data () {
      return{
        categories:['business', 'entertainment', 'general', 'health', 'science', 'sports', 
                    'technology'],
        
        countries:['ae', 'ar', 'at', 'au', 'be', 'bg', 'br', 'ca', 'ch', 'cn', 'co', 'cu', 
                    'cz', 'de', 'eg', 'fr', 'gb', 'gr', 'hk', 'hu', 'id', 'ie', 'il', 'in', 
                    'it', 'jp', 'kr', 'lt', 'lv', 'ma', 'mx', 'my', 'ng', 'nl', 'no', 'nz', 
                    'ph', 'pl', 'pt', 'ro', 'rs', 'ru', 'sa', 'se', 'sg', 'si', 'sk', 'th', 
                    'tr', 'tw', 'ua', 'us', 've', 'za'],
        
        languages: ['ar', 'de', 'en', 'es', 'fr', 'he', 'it', 'nl', 'no', 'pt', 'ru', 'se', 
                    'ud', 'zh'],
        
        category_value: [],
        country_value: [],
        language_value: [],
        query: [],
        sources: [],
        errors: []
      }
  },

  created () {
    axios.get('https://newsapi.org/v2/sources?language=en&apiKey='+this.api_key)
      .then(response => {
        //this.articles = response.data.articles
        this.sources = response.data.sources
        console.log('data:')
        console.log(response.data.sources) // This will give you access to the full object
      })
      .catch(e => {
        this.errors.push(e)
      })
  },

  methods: {
      filterResults() {
          var src_str="";
          if (this.category_value.length) {
              src_str+='category=' + this.category_value + "&";
          }
          if (this.country_value.length) {
              src_str+='country=' + this.country_value + "&";
          }
          if (this.language_value.length) {
              src_str+='language=' + this.language_value + "&";
          }
          if (this.query.length) {
              src_str+='q=' + this.query + "&";
          }  
        console.log(src_str);
        this.$emit('selectsource',src_str)
      },

      selectSource(source){
        this.$emit('selectsource',source)
      }
  }

}
</script>

<style scoped>
  #style-1::-webkit-scrollbar {
    width: 6px;
    background-color: #F5F5F5;
  }
  #style-1::-webkit-scrollbar-thumb {
    background-color: #F90; 
    background-image: -webkit-linear-gradient(90deg, rgba(255, 255, 255, .2) 25%,
                        transparent 25%,
                        transparent 50%,
                        rgba(255, 255, 255, .2) 50%,
                        rgba(255, 255, 255, .2) 75%,
                        transparent 75%,
                        transparent)
  }
  #style-1::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
  }
  .drawer-style {
    background-color: #2196F3 !important;
    border-color: #2196F3 !important;
  }
</style>