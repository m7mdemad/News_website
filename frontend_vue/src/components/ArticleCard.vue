<template>
              <v-card class="my-3" hover>
                <v-img
                  height="350px"
                  v-bind:src="article.urlToImage"
                ></v-img>
                  <v-container fill-height fluid>
                    <v-layout>
                      <v-flex xs12 align-end d-flex>
                        <span class="headline">{{ article.title }}</span>
                      </v-flex>
                    </v-layout>
                  </v-container>
                <v-card-text>
                  (written by: {{article.author}}, published at: {{article.publishedAt}}) {{ article.description }}
                </v-card-text>
                <v-card-actions>
                  <v-chip small color="secondary" class="white--text">
                    {{article.source.name}}
                  </v-chip>
                  <v-spacer></v-spacer>
                  
                  <v-btn flat icon @click="isPressed()" :style="{
           color: changeBackgroundColor ? 'grey' : 'red'
           }" >
                    <v-icon>favorite</v-icon>
                 </v-btn>
                  <v-spacer></v-spacer>

         <v-btn small replace color="info" v-bind:href="article.url" target="_blank" >Read More</v-btn>
                </v-card-actions>
              </v-card>

</template>

<script>
import gql from 'graphql-tag'

export default {
  name: 'MainContent', 
  data () {
      return {
       changeBackgroundColor: true,
      }
    }, 
  props: {
      article: Object,
      user_id: Number,
      user_token: String
  },
  methods: {
            isPressed(){  
              if(!this.changeBackgroundColor) {return;}        
              
              console.log( this.user_id,
                  this.article.title, 
                  this.article.author,
                  this.article.publishedAt,
                  this.article.description,
                  this.article.url,
                  this.article.urlToImage)
              this.$apollo.mutate({
              // Query
              mutation: gql`mutation ($data: CreateArticleInput!) {
                createArticle(input: $data) {
                  title
                }
              }`,
              // Parameters
              variables: {
                data: {
                  user_id: this.user_id,
                  title: this.article.title, 
                  author_name: this.article.author,
                  published_at: "2020-12-01",
                  content: this.article.description,
                  article_url: this.article.url,
                  image_url: this.article.urlToImage
                  
                }
              }
            }).then(() => {
              this.changeBackgroundColor = !this.changeBackgroundColor;
              alert('Article added to the favourites')
            }).catch((error) => {
              alert('Please sign in, if you are already signed in then something went wrong!')
              console.error(error)
            })




            }
    }
}
</script>