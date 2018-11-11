
require('../../js/bootstrap');
/*require('../assets/js/jquery-3.2.1.min');
require('../assets/js/popper');
require('../assets/js/bootstrap.min');*/
require('../assets/js/stellar');
require('../assets/vendors/lightbox/simpleLightbox.min');
require('../assets/vendors/nice-select/js/jquery.nice-select');
require('../assets/vendors/isotope/imagesloaded.pkgd.min');
require('../assets/vendors/owl-carousel/owl.carousel.min');
require('../assets/js/jquery.ajaxchimp.min');
require('../assets/vendors/counter-up/jquery.waypoints.min');
require('../assets/vendors/flipclock/timer');
// require('../assets/vendors/jquery-ui/jquery-ui');  Disabled cuz of broken links
require('../assets/vendors/counter-up/jquery.counterup');
require('../assets/js/mail-script');
require('../assets/js/theme');

window.Vue = require('vue');

import { store } from './store/store';
// Import toast message notifications
import Toast from '../../js/packages/toast/toast';
Vue.use(Toast);

Vue.component('range-slider', require('./components/RangeSlider'));
Vue.component('lazy-image', require('./components/LazyImage'));
Vue.component('product-description-area', require('./components/ProductDescription'));
Vue.component('shopping-cart', require('./components/ShoppingCart'));
Vue.component('shopping-cart-counter', require('./components/ShoppingCartCounter'));
Vue.component('cart-items', require('./components/CartItems'));

const app = new Vue({
  el: '#app',
  store
});