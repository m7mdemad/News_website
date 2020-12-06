import gql from 'graphql-tag';

export const retriveArticles = gql`
query ($id: Int!){
    article(user_id: $id) {
            title
            author_name
            content
            article_url
            image_url
    }
}`;