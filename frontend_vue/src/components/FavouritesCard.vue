<template>
              <v-card class="my-3" hover>
                <v-img
                  height="350px"
                  v-bind:src="article.image_url"
                ></v-img>
                  <v-container fill-height fluid>
                    <v-layout>
                      <v-flex xs12 align-end d-flex>
                        <span class="headline">{{ article.title }}</span>
                      </v-flex>
                    </v-layout>
                  </v-container>
                <v-card-text>
                  (written by: {{article.author_name}}) {{ article.content }}
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  
                  <v-btn flat icon @click="isPressed()" :style="{
                                            color: changeBackgroundColor ? 'grey' : 'red'}" >
                    <v-icon>favorite</v-icon>
                 </v-btn>
                  <v-spacer></v-spacer>

                 <v-btn small replace color="blue" v-bind:href="article.article_url" target="_blank" >Read More</v-btn>
                </v-card-actions>
              </v-card>

</template>

<script>
import gql from 'graphql-tag'

export default {
  name: 'MainContent', 
  data () {
      return {
       changeBackgroundColor: false,
      }
    }, 
  props: {
      article: Object,
      user_id: Number,
      user_token: String
  },
  methods: {
            isPressed(){  
              if(this.changeBackgroundColor) {return;}        
              
              
              this.$apollo.mutate({
              // Query
              mutation: gql`mutation ($data: dropArticleInput!) {
                dropArticle(input: $data) {
                  status
                }
              }`,
              // Parameters
              variables: {
                data: {
                  user_id: 51,
                  title: this.article.title
                  
                }
              }
            }).then(() => {
              this.changeBackgroundColor = !this.changeBackgroundColor;
              alert('Article removed from the favourites')
            }).catch((error) => {
              alert('Please sign in, if you are already signed in then something went wrong!')
              console.error(error)
            })




            }
    }
}
</script>