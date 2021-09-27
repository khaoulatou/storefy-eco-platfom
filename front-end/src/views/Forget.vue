<template>
  <h1>
    reset your password
  </h1>
  <form @submit.prevent="forget">
    <label for="email">
      email :
    </label>
    <input type="email" id="email" name="email">
    <input type="submit" value="forget">
  </form>
</template>

<script>
import getFormData from '../assets/helpers/formData';
import sendRequest from '../assets/helpers/fetch';
import swal from 'sweetalert';

export default {
  name: 'Forget',
  setup() {
    async function forget(e) {
      const data = getFormData(Object.fromEntries(new FormData(e.target)));
      const response = await sendRequest('forget', data, 'POST', false);
      if (response[1] === 201) {
        swal('Good job!', 'we send link to your email check it!', 'success');
      }
    }

    return {
      forget
    };
  }
};
</script>
