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
Vue.component('font-awesome-icon', require('@fortawesome/vue-fontawesome'));

Vue.component('page', require('./components/partials/Dashboard'));

import Auth from './packages/auth/Auth';
import Toast from './packages/toast/toast';
import { router } from "./routes";
import { store } from "./store/store";

import fontawesome from '@fortawesome/fontawesome';
import faPlus from '@fortawesome/fontawesome-free-solid/faPlus';
import faEnvelope from '@fortawesome/fontawesome-free-solid/faEnvelope';
import faBell from '@fortawesome/fontawesome-free-solid/faBell';
import faCommentAlt from '@fortawesome/fontawesome-free-solid/faCommentAlt';
import faChevronCircleDown from '@fortawesome/fontawesome-free-solid/faChevronCircleDown';
import faCogs from '@fortawesome/fontawesome-free-solid/faCogs';
import faAngleRight from '@fortawesome/fontawesome-free-solid/faAngleRight';
import faHome from '@fortawesome/fontawesome-free-solid/faHome';
import faUsers from '@fortawesome/fontawesome-free-solid/faUsers';
import faPaste from '@fortawesome/fontawesome-free-solid/faPaste';
import faShoppingCart from '@fortawesome/fontawesome-free-solid/faShoppingCart';
import faAlignJustify from '@fortawesome/fontawesome-free-solid/faAlignJustify';
import faPencilAlt from '@fortawesome/fontawesome-free-solid/faPencilAlt';
import faTimes from '@fortawesome/fontawesome-free-solid/faTimes';
import faLink from '@fortawesome/fontawesome-free-solid/faLink';
import faBars from '@fortawesome/fontawesome-free-solid/faBars';
import faAmountUp from '@fortawesome/fontawesome-free-solid/faSortAmountUp';
import faImages from '@fortawesome/fontawesome-free-solid/faImages';
import faRandom from '@fortawesome/fontawesome-free-solid/faRandom';
import faThLarge from '@fortawesome/fontawesome-free-solid/faThLarge';
import faTags from '@fortawesome/fontawesome-free-solid/faTags';
import faCopy from '@fortawesome/fontawesome-free-solid/faCopy';
import faEye from '@fortawesome/fontawesome-free-solid/faEye';
import faShoppingBasket from '@fortawesome/fontawesome-free-solid/faShoppingBasket';
import faExclamation from '@fortawesome/fontawesome-free-solid/faExclamation';
import faStream from '@fortawesome/fontawesome-free-solid/faStream';
import faPlusSquare from '@fortawesome/fontawesome-free-solid/faPlusSquare';

fontawesome.library.add(
    faPlus, faEnvelope, faBell, faCommentAlt, faChevronCircleDown, faCogs, faAngleRight, faHome, faUsers, faPaste, faShoppingCart, faAlignJustify, faPencilAlt, faTimes,
    faLink, faBars, faAmountUp, faImages, faRandom, faThLarge, faTags, faCopy, faEye, faShoppingBasket, faExclamation, faStream, faPlusSquare,
);

Vue.use(Auth);
Vue.use(Toast);

/**
 * Manage route access
 */
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
    else if (to.matched.some(record => record.meta.permission)) {

      // Check route permission based on route meta "permission" value...
      let permissions = store.getters['user/getUser'].role.permissions;
      let pass;

      permissions.forEach(function (permission) {
        if (to.meta.permission === permission.title)
          pass = true;
        if (store.getters['user/isAdmin'])
          pass = true;
      });

      if (pass) {
        next();
      }
      else {
        next('/home');
      }
    }
    // else conditions
  }
);

Vue.mixin({
  methods: {
    /*
      Determine does user have permission to see links
     */
    can(permissionName) {
      let user = this.user;  // computed property from component where this method is called
      let allow;
      user.role.permissions.forEach(function (permission) {
        if (store.getters['user/isAdmin'])
          allow = true;
        if (permission.title === permissionName)
          allow = true;
      });
      return allow;
    },
  }
});

const app = new Vue({
  el: '#app',
  router: router,
  store,
});
