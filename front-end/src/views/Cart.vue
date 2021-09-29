<template>
  <div class="home">
    <CartComponent />
  </div>
</template>

<script>
import CartComponent from '../components/CartComponent.vue';
export default {
  //   components: { Panier },
  name: "Cart",
  components: {
    CartComponent,
  },
};
</script>

<style>
</style>