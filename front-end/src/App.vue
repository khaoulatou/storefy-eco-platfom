<template>
  <div id="nav">
    <router-link to="/login">login</router-link>
    |
    <router-link to="/register">register</router-link>
    |
    <router-link to="/forget">forget password</router-link>
    |
    <router-link to="/pixel">pixel</router-link>
    |
    <router-link to="/product">Product</router-link>
    |
    <router-link to="/cart">Cart</router-link>
  </div>
  <router-view />
    <div v-if="message.message" :class="[message.error?'error-message':'success-message','flash-message']">
    {{message.message}}
  </div>
</template>
<script>
export default {
  inject:['message']
}
</script>
<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
.error-message {
  color: red;
}
.success-message {
  color: greenyellow;
}
.flash-message {
  padding: 12px 25px;
  border-radius: 15px;
  position: fixed;
  bottom: 15px;
  right: 10px;
  font-size: 20px;
  width: 250px;
  background-color: #Fff;
}
</style>
