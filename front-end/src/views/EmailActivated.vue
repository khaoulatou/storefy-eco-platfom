<template>
  <div v-if="!fetching">
    {{ response.message }}
  </div>
  <div v-else>waitting...</div>
</template>
<script>
import { ref } from "@vue/reactivity";
import useFetch from "../hooks/useFetch";
export default {
  name: "EmailActivated",
  props: {
    link: { required: true, type: String },
  },
  setup(props) {
    //   return ;
    let fetching = ref(null);
    let errors = ref(null);
    let response = ref(null);
    console.log(props.link);
    (async()=>{
        let reponse = await useFetch(props.link);
        console.log(response);
    })();
    return {
      fetching,
      response,
      errors,
    };
  },
};
</script>

<style>
</style>