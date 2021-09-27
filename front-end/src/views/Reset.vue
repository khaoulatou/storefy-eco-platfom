<template>
  <form @submit.prevent="reset">
    <div class="group__input">
      <label for="email">
        email :
      </label>
      <input type="email" id="email" name="email">
    </div>
    <div class="group__input">
    </div>
    <div class="group__input">
      <label for="password">
        password :
      </label>
      <input type="password" id="password" name="password">
    </div>
    <div class="group__input">
      <label for="password_confirmation">
        password confirmation :
      </label>
      <input type="password" id="password_confirmation" name="password_confirmation">
    </div>
    <input type="submit" value="save">
  </form>
</template>

<script>
import getFormData from '../assets/helpers/formData';
import sendRequest from '../assets/helpers/fetch';
import swal from 'sweetalert';
import { useRoute, useRouter } from 'vue-router';

export default {
  name: 'Reset',
  setup() {
    const router = useRouter();
    const route = useRoute();

    async function reset(e) {
      const data = getFormData(Object.fromEntries(new FormData(e.target)));
      data.append('token', route.params?.token);
      const response = await sendRequest('reset', data, 'POST', false);
      console.log(route.params.token);
      console.log(response);
      if (response[1] !== 201) {
        await swal('bad job!', response[0].message, 'error');
      } else {
        await swal('Good job!', response[0].message, 'success');
      }
    }

    return {
      reset
    };
  }
};
</script>

<style scoped>

</style>
