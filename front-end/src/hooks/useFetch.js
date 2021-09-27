import { reactive, toRefs } from 'vue';

export default async function (endpoint, options) {
  const states = reactive({
    errors: null,
    fetching: true,
    response: null
  });
  const fetch = async (url, opts) => {
    try {
      let response = await fetch(url, opts);
      states.response = await response.json();
    } catch ($e) {
      states.errors = $e;
    } finally {
      states.fetching = false;
    }
  };
  await fetch(endpoint, options);
  return {
    ...toRefs(states)
  };
}
