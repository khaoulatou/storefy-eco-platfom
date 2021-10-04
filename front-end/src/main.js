import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import { reactive } from '@vue/reactivity';
 const message = reactive({ message: "",error:false })
createApp(App).use(store).use(router).provide('message',message).mount('#app');
