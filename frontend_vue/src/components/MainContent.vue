<template>
    <v-layout row wrap align-center>
          <v-flex xs8  offset-md2>
            <div v-for="article in articles" :key="article.title">
              <ArticleCard :user_token="user_token" :user_id="user_id" :article="article"></ArticleCard>
            </div>
          </v-flex>
        </v-layout>
</template>

<script>
import ArticleCard from './ArticleCard.vue' 


export default {

  name: 'MainContent', 
  components: {
        ArticleCard // Register the component
    },
  props: {
      articles: Array,
      user_id: Number,
      user_token: String
  },
}
</script>