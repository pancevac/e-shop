/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

// Load admin template js
require('./assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min');
require('./assets/extra-libs/sparkline/sparkline');
require('./dist/js/waves');
require('./dist/js/sidebarmenu');
require('./dist/js/custom');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('container', require('./components/Container'));

// Navigation
Vue.component('preloader', require('./components/partials/Preloader'));
Vue.component('top-bar', require('./components/partials/TopBar'));
Vue.component('left-bar', require('./components/partials/LeftBar'));
Vue.component('breadcrumb', require('./components/partials/Breadcrumb'));

// Form Helper
Vue.component('text-field', require('./components/helper/form/TextField'));
Vue.component('password-field', require('./components/helper/form/PasswordField'));
Vue.component('email-field', require('./components/helper/form/EmailField'));
Vue.component('text-area-field', require('./components/helper/form/TextAreaField'));
Vue.component('checkbox-field', require('./components/helper/form/CheckBoxField'));
Vue.component('select-field', require('./components/helper/form/SelectField'));
Vue.component('select-multiple-field', require('./components/helper/form/SelectMultipleField'));

Vue.component('page', require('./components/partials/Content'));

import Auth from './packages/auth/Auth';
import { router } from "./routes";
import { store } from "./store/store";

Vue.use(Auth);

router.beforeEach(
  (to, from, next) => {
    if (to.matched.some(record => record.meta.guest)) {
      if (Vue.auth.isAuth()) {
        next({ path: '/home' })
      }
      else next();
    }
    else if (to.matched.some(record => record.meta.auth)) {
      if (Vue.auth.isAuth()) {
        next();
      }
      else next({ path: '/login' });
    }
    // else conditions
  }
);

const app = new Vue({
  el: '#app',
  router: router,
  store,
});
