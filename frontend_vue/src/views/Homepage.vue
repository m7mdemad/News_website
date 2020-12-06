<template>
  <v-app light>
  <SideMenu :drawer="drawer"  :api_key="api_key" @selectsource="setResource" ></SideMenu><!--add this component in the template --> 
<v-toolbar fixed app light clipped-left color="primary" class="elevation-2">
    <v-toolbar-side-icon @click="drawer = !drawer"   class="white--text"></v-toolbar-side-icon>
    <v-spacer />
    <v-toolbar-title class="white--text">Yodway News</v-toolbar-title>
    <v-spacer />

    <div v-if='user_id === -1'>
        <v-btn depressed  @click="goToregister()" color="grey">Register</v-btn>
        <v-btn depressed @click="goTologin()" color="blue">Login</v-btn>
    </div>
    <div v-else>
        <v-btn depressed  @click="goTofavourites()" color="blue">Favourites</v-btn>
        <v-btn depressed  @click="logOut()" color="red">Logout</v-btn>
    </div>
  </v-toolbar>
  <v-content>
    <v-container fluid>
      <MainContent :user_token="token" :user_id="id" :articles="articles"></MainContent> 
    </v-container>
   </v-content>
      <!-- <router-view/> -->
</v-app>
  
</template>
<script>
import { onLogout} from '../vue-apollo.js'
import axios from 'axios' 
import MainContent from '../components/MainContent.vue' 
import SideMenu from '../components/SideMenu.vue' // import the SideMenu component
export default {
      components: {
        MainContent,
        SideMenu // Register the component
      },
      props: {
      id: Number,
      token: String,
      email: String
    },
    data () {
      return {
       user_id:-1,
       user_token: "",
       drawer: false,
       notSigned: true,
       api_key:'29fe467120be45df9be2ae506ae6d23b', 
       articles: [],
       errors: [] 
      }
    },
    created () {
        this.user_id = this.id
        this.user_token = this.token
      axios.get('https://newsapi.org/v2/top-headlines?sources=techcrunch,bbc-news&apiKey='+this.api_key)
        .then(response => {
          this.articles = response.data.articles
          console.log(response.data.articles[0].name) // This will give you access to the full object
        })
        .catch(e => {
          this.errors.push(e)
        })
     },
     //add the methodes events hadler with setResource() function
      methods: {
            setResource(source){             axios.get('https://newsapi.org/v2/top-headlines?'+source+'apiKey='+this.api_key)
              .then(response => {
                this.articles = response.data.articles
                if(this.articles.length === 0){
                    alert('Sorry, No results found')
                }
                console.log(source)            
              })
              .catch(e => {
                this.errors.push(e)
              })

            },
            goTologin(){
              this.$router.push('login').catch(()=>{});
            },
            goToregister(){
              this.$router.push('register').catch(()=>{});
            },
            goTofavourites(){
              this.$router.push('favourites').catch(()=>{});
            },
            logOut(){
                onLogout(this.$apollo.provider.defaultClient)
                this.user_id = -1
                this.user_token = ""
                window.location.reload()
            }
         }
  }
</script>