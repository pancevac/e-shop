
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Css
// Js

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
Vue.component('preloader', require('./components/partials/Preloader'));
Vue.component('top-bar', require('./components/partials/TopBar'));
Vue.component('left-bar', require('./components/partials/LeftBar'));
Vue.component('breadcrumb', require('./components/partials/Breadcrumb'));
Vue.component('page', require('./components/partials/Content'));
//Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
