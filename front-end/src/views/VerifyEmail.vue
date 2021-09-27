<template>
<div v-if='message'>
    <h1>Verifying email</h1>
    <p>{{message}}</p>
    <button @click='ToHome'>To home</button>
</div>
<div v-else>
<lord-icon
    src="https://cdn.lordicon.com/ymrqtsej.json"
    trigger="loop"
    colors="primary:#121331"
    style="width:250px;height:250px">
</lord-icon>
</div>

</template>

<script>
// import { mapActions } from "vuex";
export default {
  name: "VerifyEmail",
  data(){
      return {
          message :null,
      }
  },
  methods: {
    // ...mapActions({
    //   verifyEmail: "user/verifyEmail",
    //   addNotification: "application/addNotification",
    // }),
    ToHome() {
        this.$router.push('/login');
    }
  },
  created() {
    fetch(`http://localhost:8000/api/v1/verify-email?id=${this.$route.query.id}&hash=${this.$route.query.hash}`)
    .then(response=>response.json())
    .then(data=>{
        console.log(data);
        this.message = data.message;
    })
  },
};
</script>

<style scoped>
</style>