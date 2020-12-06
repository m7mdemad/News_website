<template>

  <v-app light>
        <v-toolbar fixed app light clipped-left color="blue" class="elevation-2">
            <v-toolbar-title class="white--text">My favourites</v-toolbar-title>
            <v-spacer />

            <!-- <div> -->
                <v-btn depressed @click="goToUpdatepassword()" color="blue">Update password</v-btn>
                <v-btn depressed  @click="logOut()" color="red">Logout</v-btn>
            <!-- </div> -->
        </v-toolbar>

        <v-content>
            <v-container fluid>
                <v-layout row wrap align-center>
                    <v-flex xs8  offset-md2>
                        <div v-for="a in article" :key="a.title">
                            <FavouritesCard :user_token="token" :user_id="id" :article="a"></FavouritesCard>
                        </div>
                     </v-flex>
                </v-layout>
         </v-container>
        </v-content>
    </v-app>
</template>

<script>
import { onLogout} from '../vue-apollo.js'
import FavouritesCard from '../components/FavouritesCard.vue' 
import gql from 'graphql-tag'
// import {retriveArticles} from '../graphql/queries/retriveArticles';

export default {
  components: {
        FavouritesCard
    },

  data () {
      return {
       changeBackgroundColor: false,
       article: []
      }
    }, 
  props:{
      id: Number,
      email: String,
      token: String
  },


  apollo: {
        article: {
            query: gql`query article($user_id: Int!) {
                article(user_id: $user_id){
                    title
                    image_url
                    author_name
                    content
                    article_url
                }
            }`,
            variables() {
                return{
                user_id: this.id
                }
            }
        }
    },
    methods: {
            goToUpdatepassword(){
              this.$router.push('updatepassword').catch(()=>{});
            },
            logOut(){
                onLogout(this.$apollo.provider.defaultClient)
                this.id = -1
                this.token = ""
                this.email = ""
                this.$emit('setUser',-1, "", "")
              this.$router.push('/').catch(()=>{});
            }
         }
}
</script>