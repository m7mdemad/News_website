<template>
      <router-view :email='useremail' :token='userToken' :id='userid'  @setUser="update"></router-view>  
</template>

<script>
export default {
  data () {
      return {
       userid: -1,
       userToken: "",
       useremail: ""
      }
  },
  methods: {
    update(id, utoken, email){
      this.userid = Number(id)
      // Deep copy
      this.userToken = (' ' + utoken).slice(1);
      this.useremail = (' ' + email).slice(1);
      console.log('App ', this.id, this.userToken, this.useremail)
    }
  }
}
</script>
