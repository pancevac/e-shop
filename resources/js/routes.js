import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export const router = new VueRouter({
  routes: [

    { path: '/login', component: require('./views/auth/Login'), meta: { guest: true }},
    { path: '/logout', component: require('./views/auth/Logout'), meta: { auth: true }},
    { path: '/home', component: require('./components/partials/Content'), meta: { auth: true }},
    { path: '/test', component: require('./components/partials/test'), meta: { auth: true }},
    { path: '/users/create', component: require('./views/users/UserCreate'), meta: {auth: true }}
  ]
});