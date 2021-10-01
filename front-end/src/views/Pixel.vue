<template>
  <div>
    <form @submit.prevent="addPixel">
      <div class="group__input"></div>
      <div class="group__input">
        <label for="name"> name : </label>
        <input type="text" id="name" name="name" />
      </div>
      <div class="group__input">
        <label for="pixel"> pixel : </label>
        <input type="text" id="pixel" name="pixel" />
      </div>
      <input type="submit" value="save" />
    </form>
    <div>
      <div v-for="pixel in pixels" :ref="'pixel-' + pixel.id">
        <div>
          pixel: <span>{{ pixel.name }}</span>
        </div>
        <button class="danger" @click="deletePixel(pixel.id)">
          delete pixel
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import getFormData from "../assets/helpers/formData";
import sendRequest from "../assets/helpers/fetch";
import swal from "sweetalert";
import { ref } from "vue";

export default {
  name: "Pixel",
  setup() {
    const pixels = ref(null);

    async function addPixel(e) {
      const data = getFormData(Object.fromEntries(new FormData(e.target)));
      const response = await sendRequest("pixel", data, "POST", true);
      if (response[1] === 201) {
        e.target.reset();
        pixels.value.push(response[0].data);
        swal("Good job!", "pixel added successfully!", "success");
      }
    }

    (async () => {
      let response = await sendRequest("pixel", null, "GET", true);
      console.log(response);
      pixels.value = response[0].data;
      console.log(pixels.value);
    })();

    async function deletePixel(pixel) {
      let response = await sendRequest(`pixel/${pixel}`, null, "DELETE", true);
      console.log(response);
      if (response[1] === 201) {
        pixels.value = pixels.value.filter((element) => element.id !== +pixel);
        swal("Good job!", "pixel deleted successfully!", "success");
      }
    }

    return {
      pixels,
      deletePixel,
      addPixel,
    };
  },
};
</script>

<style scoped>
.danger {
  color: red;
}
</style>
