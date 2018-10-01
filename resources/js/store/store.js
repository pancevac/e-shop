import Vue from 'vue';
import Vuex from 'vuex';
import user from './modules/user';
import search from './modules/search';

Vue.use(Vuex);

export const store = new Vuex.Store({
  modules: {
    user,
    search
  }
});