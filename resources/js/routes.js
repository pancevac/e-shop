import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export const router = new VueRouter({
  routes: [

    { path: '/login', component: require('./views/auth/Login'), meta: { guest: true }},
    { path: '/logout', component: require('./views/auth/Logout'), meta: { auth: true }},
    { path: '/home', component: require('./components/partials/Content'), meta: { auth: true }},
    { path: '/users', component: require('./views/users/UserList.vue'), meta: { auth: true }},
    { path: '/users/create', component: require('./views/users/UserCreate'), meta: {auth: true }},
    { path: '/users/:id/edit', component: require('./views/users/UsersEdit'), meta: {auth: true}},

    // Brands
    { path: '/brands', component: require('./views/brands/BrandList'), meta: {auth: true}},
    { path: '/brands/create', component: require('./views/brands/BrandCreate'), meta: {auth: true}},
    { path: '/brands/:id/edit', component: require('./views/brands/BrandEdit'), meta: {auth: true}},

    // Category
    { path: '/categories', component: require('./views/categories/CategoryList'), meta: {auth: true}},
    { path: '/categories/create', component: require('./views/categories/CategoryCreate'), meta: {auth: true}},
    { path: '/categories/:id/edit', component: require('./views/categories/CategoryEdit'), meta: {auth: true}},
    { path: '/categories/sort', component: require('./views/categories/CategorySort'), meta: {auth: true}},
  ]
});