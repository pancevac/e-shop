
require('./bootstrap');

require('./theme');

require('./vendor/index');

import 'jquery-sticky';

import carousel from 'vue-owl-carousel'

window.Vue = require('vue');

Vue.component('gallery', {

  components: { carousel },

  data() {
    return {
      //
    }
  },

});

const app = new Vue({
  el: '#app',
});