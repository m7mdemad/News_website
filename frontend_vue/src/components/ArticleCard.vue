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
                  {{ article.description }}
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
export default {
  name: 'MainContent', 
  data () {
      return {
       changeBackgroundColor: true,
      }
    }, 
  props: {
      article: Object
  },
  methods: {
            isPressed(){             
                this.changeBackgroundColor = !this.changeBackgroundColor;
            }
    }
}
</script>