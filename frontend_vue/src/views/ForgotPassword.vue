<template>
<v-app light>
  <v-content :style="{position: 'fixed', top: '20%', left: '40%'}">
    <v-container fluid>
        <form action="" method="POST" @submit.prevent="sendPassword">
            <h3 center>Forgot password</h3>

            <div class="form-group">
                <label>Email address</label>
                <input required class="form-control form-control-lg" type="email" v-model="email" name="email" id="email" placeholder="Email">
            </div>


            <button type="submit" class="btn btn-dark btn-lg btn-block">Send Email</button>
        </form>    
    </v-container>
   </v-content>
</v-app>

  <!-- <div>
    <form action="" method="POST" @submit.prevent="sendPassword">

      <div>
        <input required type="email" v-model="email" name="email" id="email" placeholder="Email">
      </div>

      <div>
        <button type="submit">Send the email</button>
      </div>
    </form>
  </div> -->
</template>

<script>
import gql from 'graphql-tag'
export default {
    data() {
    return {
    }
  },
  methods: {
    sendPassword() {
      this.$apollo.mutate({
        // Query
        mutation: gql`mutation ($data: ForgotPasswordInput!) {
          forgotPassword(input: $data) {
            status,
            message
          }
        }`,
        // Parameters
        variables: {
          data: {
            email: this.email
          }
        }
      }).then(() => {
        alert('Please check your email to reset the password, Email sent')       
        this.$router.push('/login')
      }).catch((error) => {
        alert(error)
        console.error(error)
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