<template>
  <div>
    <form action="" method="POST" @submit.prevent="updatePassword">

      <div>
          <b>Old password:</b>
        <input required min=8 type="password" v-model="oldpassword" name="oldpassword" id="oldpassword" placeholder="Old password">
      </div>

        <div>
          <b>New password:</b>
        <input required type="password" min=8 v-model="newpassword" name="newpassword" id="newpassword" placeholder="New password">
      </div>

      <div>
          <b>Confirm new password:</b>
        <input required type="password" min=8 v-model="newpassword2" name="newpassword2" id="newpassword2" placeholder="Re-enter new password">
      </div>
      <div>
        <button type="submit">Update password</button>
      </div>
    </form>
  </div>
</template>

<script>
import { onLogout} from '../vue-apollo.js'
import gql from 'graphql-tag'

export default {
    props: {
        email: String
    },
    data() {
    return {
      oldpassword: '',
      newpassword: '',
      newpassword2: ''
    }
  },
  methods: {
    updatePassword() {
      if(this.newpassword !== this.newpassword2) {
          alert('New password and confirmed password does not match')
          return
      }

      this.$apollo.mutate({
        // Query
        mutation: gql`mutation ($data: UpdatePassword!) {
          updateThePassword(input: $data) {
            status,
            message
          }
        }`,
        // Parameters
        variables: {
          data: {
            username: this.email,
            old_password: this.oldpassword,
            password: this.newpassword,
            password_confirmation: this.newpassword2
          }
        }
      }).then(() => {
        alert('Password updated successfully')
        onLogout(this.$apollo.provider.defaultClient)
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