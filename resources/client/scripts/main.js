
require('./bootstrap');
require('./theme');
require('./vendor/index');

import 'jquery-sticky';
import Toast from '../../js/packages/toast/toast';
import { store } from './store/store';

window.Vue = require('vue');

Vue.component('add-to-cart', require('./components/AddToCart'));
Vue.component('add-to-wish-list', require('./components/AddToWishList'));
Vue.component('product-reviews', require('./components/comments'));
Vue.component('product-gallery', require('./components/ProductGallery'));

Vue.use(Toast);

const app = new Vue({
  el: '#app',
  store
});