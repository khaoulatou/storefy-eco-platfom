<template>
  <div v-if="!IsSend">
    <div>
      we send to you a link for activate your account in your address email
    </div>
    <button @click="resendEmail">
      resend activation
    </button>
  </div>
  <div v-if="IsSend">
    <lord-icon
      src="https://cdn.lordicon.com/lupuorrc.json"
      trigger="loop"
      colors="primary:#121331,secondary:#08a88a"
      style="width:250px;height:250px">
    </lord-icon>
    <h2>check your email !</h2>
  </div>
</template>

<script>

import swal from "sweetalert";

export default {
  name: "verifiedAccount",
  data() {
    return {
      IsSend: false,
    }
  },
  computed: {
    email() {
      return this.$route.query.email
    }
  },
  methods: {
    async resendEmail() {
      let email = this.email;
      console.log(email)
      const request = await fetch(`http://localhost:8000/api/v1/resend?email=${email}`, {method: 'POST'});
      const {message, success} = await request.json();
      if (success) {
        await swal("Good job!", message, "success").then(() => {
          this.IsSend = true;
        });
      } else {
        await swal("bad job!", message, "error");

      }

    }
  },
  beforeRouteEnter(routeTo, routeFrom, next) {
    if (routeFrom.name === 'login' && routeTo.query.email) {
      next()
    }
    next('/')
  }
}
</script>

<style scoped>

</style>
