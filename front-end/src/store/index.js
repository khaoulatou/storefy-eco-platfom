import { createStore } from 'vuex';
//modules
import user from './user/index'
import application from './application/index'
export default createStore({
  state: {},
  mutations: {},
  getters: {},
  actions: {},
  modules: {user,
    application},
});
