<template>
  <v-app light>
  <SideMenu :drawer="drawer" @selectsource="setResource" ></SideMenu><!--add this component in the template --> 
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
      <MainContent :user_token="token" :user_id="id" :articles="filterednews"></MainContent> 
    </v-container>
   </v-content>
      <!-- <router-view/> -->
</v-app>
  
</template>
<script>
import gql from 'graphql-tag'
import { onLogout} from '../vue-apollo.js'
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
       filters: "category=general&",
       filterednews: []
      }
    },
    
    apollo: {
        filterednews: {
            query: gql`query filterednews($f: String!) {
                filterednews(filters: $f){
                  source{
                    id
                    name
                  }
                  author
                  title
                  description
                  url
                  urlToImage
                  publishedAt
                  content
                }
            }`,
            variables() {
                return{
                  f: this.filters
                }
            },
        }
    },

    created () {
        this.user_id = this.id
        this.user_token = this.token
        // this.$apollo.queries.filterednews.skip = true
     },
     //add the methodes events hadler with setResource() function
      methods: {
            setResource(source){ 
              console.log(source)
                

                if (source === "") {
                  this.filters = "category=general&language=en&"
                }
                else { this.filters = source  }
             
                if(this.filterednews.length === 0){
                    alert('Sorry, No results found')
                }

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