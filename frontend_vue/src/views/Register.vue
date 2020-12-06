<template >
<v-app light>
  <v-content :style="{position: 'fixed', top: '20%', left: '40%'}">
    <v-container fluid>
        <form action="" method="POST" @submit.prevent="register">
            <h3 center>Register</h3>

            <div class="form-group">
                <label>Email address</label>
                <input required class="form-control form-control-lg"  type="email" v-model="email" name="email" id="email" placeholder="Email">
            </div>

            <div class="form-group">
                <label>Name</label>
                <input required class="form-control form-control-lg" type="text" v-model="name" name="name" id="name" placeholder="Name">
            </div>

            <div class="form-group">
                <label>Birthday</label>
                <input required class="form-control form-control-lg" type="date" v-model="birthday" name="birthday" id="birthday" placeholder="Birthday">
            </div>

            <button type="submit" class="btn btn-dark btn-lg btn-block">Register</button>
        </form>    
    </v-container>
   </v-content>
</v-app>
</template>

<script>
import gql from 'graphql-tag'
export default {
//   props: {
//       id: Number,
//       token: String
//     },
    data() {
    return {
      email: '',
      name: '',
      birthday: ''
    }
  },
  methods: {
    register() {
      this.$apollo.mutate({
        // Query
        mutation: gql`mutation ($data: RegisterInput!) {
          registery(input: $data) {
            tokens {
              access_token
              refresh_token
              expires_in
              token_type
            }
          }
        }`,
        // Parameters
        variables: {
          data: {
            name: this.name,
            email: this.email,
            birthday: this.birthday,
            password: "notused...",
            password_confirmation: "notused..."
          }
        }
      }).then(() => {
        alert('Signned up successfully, please use the password sent to your email')       
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