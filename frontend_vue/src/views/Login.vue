<template>
<v-app light>
  <v-content :style="{position: 'fixed', top: '20%', left: '40%'}">
    <v-container fluid>
        <form action="" method="POST" @submit.prevent="login">
            <h3 center>Log In</h3>

            <div class="form-group">
                <label>Email address</label>
                <input required class="form-control form-control-lg" type="email" v-model="username" name="username" id="username" placeholder="Email">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input required class="form-control form-control-lg" type="password" v-model="password" name="password" id="password" placeholder="Enter your password">
            </div>


            <button type="submit" class="btn btn-dark btn-lg btn-block">Log In</button>

            <p class="forgot-password text-right mt-2 mb-4">
                <router-link to="/forgotpassword">Forgot password ?</router-link>
            </p>

        </form>    
    </v-container>
   </v-content>
</v-app>
</template>

<script>
import gql from 'graphql-tag'
import { onLogin } from '../vue-apollo.js'
export default {
  props: {
      id: Number,
      token: String
    },
    data() {
    return {
      username: '',
      password: ''
    }
  },
  methods: {
    //   push(){
    //       console.log(this.someValueToPass)
    //       this.$emit('selectsource','bl7abl7abl7a')

    //   },
    login() {
      this.$apollo.mutate({
        // Query
        mutation: gql`mutation ($data: LoginInput!) {
          login(input: $data) {
            user{
                id
                email
                name
                created_at
                updated_at
            }
            access_token
          }
        }`,
        // Parameters
        variables: {
          data: {
            username: this.username,
            password: this.password
          }
        }
      }).then((data) => {
        // Result
        console.log(data)
        onLogin(this.$apollo.provider.defaultClient, data.data.login.access_token)
        this.$emit('setUser',data.data.login.user.id, data.data.login.access_token, data.data.login.user.email)
        this.$router.push('/')
      }).catch((error) => {
        // Error
        alert('Incorrect username or password')
        console.error(error)
        // We restore the initial user input
      })
    },
  },
}
</script>

<style scoped>
  input {
    padding: 14px 20px;
    font-size: 18px;
    margin-bottom: 14px;
  }
  button {
    width: 160px;
    padding: 14px;
    background: #017BFF;
    color: white;
    font-size: 16px;
  }
</style>