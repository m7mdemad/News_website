<template>
  <v-app light>
  <SideMenu :drawer="drawer"  :api_key="api_key" @selectsource="setResource" ></SideMenu><!--add this component in the template --> 
<v-toolbar fixed app light clipped-left color="primary" class="elevation-2">
    <v-toolbar-side-icon @click="drawer = !drawer"   class="white--text"></v-toolbar-side-icon>
    <v-toolbar-title class="white--text">Yodway News</v-toolbar-title>
  </v-toolbar>
  <v-content>
    <v-container fluid>
      <MainContent :articles="articles"></MainContent> 
    </v-container>
   </v-content>
  </v-app>
</template>
<script>
import axios from 'axios' 
import MainContent from './components/MainContent.vue' 
import SideMenu from './components/SideMenu.vue' // import the SideMenu component
export default {
      components: {
        MainContent,
        SideMenu // Register the component
      },
    data () {
      return {
       drawer: false,
       api_key:'29fe467120be45df9be2ae506ae6d23b', 
       articles: [],
       errors: [] 
      }
    },
    created () {
      axios.get('https://newsapi.org/v2/top-headlines?sources=techcrunch&apiKey='+this.api_key)
        .then(response => {
          this.articles = response.data.articles
          console.log('data:')
          console.log(response.data.articles[0].name) // This will give you access to the full object
        })
        .catch(e => {
          this.errors.push(e)
        })
     },
     //add the methodes events hadler with setResource() function
      methods: {
            setResource(source){             axios.get('https://newsapi.org/v2/top-headlines?'+source+'&apiKey='+this.api_key)
              .then(response => {
                this.articles = response.data.articles
                console.log(source)            
              })
              .catch(e => {
                this.errors.push(e)
              })

            }
         }
  }
</script>