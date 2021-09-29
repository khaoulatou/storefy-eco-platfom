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
</template>

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
</style>
