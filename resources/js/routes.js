import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export const router = new VueRouter({
  routes: [

    {
      path: '/login',
      component: require('./views/auth/Login'),
      meta: {
        guest: true
      }
    },
    {
      path: '/logout',
      component: require('./views/auth/Logout'),
      meta: {
        auth: true
      }
    },
    {
      path: '/home',
      component: require('./components/partials/Content'),
      meta: {
        auth: true,
        pageTitle: 'Početna',
      }
    },

    // Users
    {
      path: '/users',
      component: require('./views/users/UserList.vue'),
      meta: {
        auth: true,
        pageTitle: 'Korisnici',
        breadcrumb: [
          {title: 'Korisnik'},
        ]
      }
    },
    {
      path: '/users/create',
      component: require('./views/users/UserCreate'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje korisnika',
        breadcrumb: [
          {title: 'Korisnik', link: '/users'},
          {title: 'Kreiranje korisnika'}
        ]
      }
    },
    {
      path: '/users/:id/edit',
      component: require('./views/users/UsersEdit'),
      meta: {
        auth: true,
        pageTitle: 'Izmena korisnika',
        breadcrumb: [
          {title: 'Korisnik', link: '/users'},
          {title: 'Izmena korisnika'}
        ]
      }
    },

    // Brands
    {
      path: '/brands',
      component: require('./views/brands/BrandList'),
      meta: {
        auth: true,
        pageTitle: 'Brendovi',
        breadcrumb: [
          {title: 'Brend'},
        ]
      }
    },
    {
      path: '/brands/create',
      component: require('./views/brands/BrandCreate'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje brenda',
        breadcrumb: [
          {title: 'Brendovi', link: '/brands'},
          {title: 'Kreiranje brenda'},
        ]
      }
    },
    {
      path: '/brands/:id/edit',
      component: require('./views/brands/BrandEdit'),
      meta: {
        auth: true,
        pageTitle: 'Izmena brenda',
        breadcrumb: [
          {title: 'Brendovi', link: '/brands'},
          {title: 'Izmena brenda'},
        ]
      }
    },

    // Category
    {
      path: '/categories',
      component: require('./views/categories/CategoryList'),
      meta: {
        auth: true,
        pageTitle: 'Kategorije',
        breadcrumb: [
          {title: 'Kategorija'}
        ]
      }
    },
    {
      path: '/categories/create',
      component: require('./views/categories/CategoryCreate'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje kategorije',
        breadcrumb: [
          {title: 'Kategorija', link: '/categories'},
          {title: 'Kreiranje kategorije'}
        ]
      }
    },
    {
      path: '/categories/:id/edit',
      component: require('./views/categories/CategoryEdit'),
      meta: {
        auth: true,
        pageTitle: 'Izmena kategorije',
        breadcrumb: [
          {title: 'Kategerija', link: '/categories'},
          {title: 'Izmena kategorije'}
        ]
      }
    },
    {
      path: '/categories/sort',
      component: require('./views/categories/CategorySort'),
      meta: {
        auth: true,
        pageTitle: 'Struktura kategorija',
        breadcrumb: [
          {title: 'Kategorija', link: '/categories'},
          {title: 'Struktura'},
        ]
      }
    },
  ]
});