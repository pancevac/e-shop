
require('./bootstrap');
require('./theme');
require('./vendor/index');

import 'jquery-sticky';
// import 'jquery-nice-select/js/jquery.nice-select.js';
import Toast from '../../js/packages/toast/toast';
import { store } from './store/store';

window.Vue = require('vue');

Vue.component('add-to-cart', require('./components/AddToCart'));
Vue.component('add-to-wish-list', require('./components/AddToWishList'));
Vue.component('product-reviews', require('./components/comments'));
Vue.component('product-gallery', require('./components/ProductGallery'));
Vue.component('lazy-image', require('./components/LazyImage'));
Vue.component('range-slider', require('./components/RangeSlider'));
Vue.component('cart-state', require('./components/CartState'));
Vue.component('cart-page', require('./components/CartPage'));
Vue.component('wish-list', require('./components/WishList'));
Vue.component('check-box', require('./components/CheckBox'));

Vue.use(Toast);

const app = new Vue({
  el: '#app',
  store
});