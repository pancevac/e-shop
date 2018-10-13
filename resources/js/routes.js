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

    // Properties
    {
      path: '/properties',
      component: require('./views/properties/PropertyList'),
      meta: {
        auth: true,
        pageTitle: 'Osobine',
        breadcrumb: [
          {title: 'Osobina'}
        ]
      }
    },
    {
      path: '/properties/create',
      component: require('./views/properties/PropertyCreate'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje osobine',
        breadcrumb: [
          {title: 'Osobina', link: '/properties'},
          {title: 'Kreiranje osobine'}
        ]
      }
    },
    {
      path: '/properties/:id/edit',
      component: require('./views/properties/PropertyEdit'),
      meta: {
        auth: true,
        pageTitle: 'Izmena osobine',
        breadcrumb: [
          {title: 'Osobina', link: '/properties'},
          {title: 'Izmena osobine'}
        ]
      }
    },

    // Attributes
    {
      path: '/attributes',
      component: require('./views/attributes/AttributeList'),
      meta: {
        auth: true,
        pageTitle: 'Atributi',
        breadcrumb: [
          {title: 'Atribut'}
        ]
      }
    },
    {
      path: '/attributes/create',
      component: require('./views/attributes/AttributeCreate'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje atributa',
        breadcrumb: [
          {title: 'Atribut', link: '/attributes'},
          {title: 'Kreiranje atributa'}
        ]
      }
    },
    {
      path: '/attributes/:id/edit',
      component: require('./views/attributes/AttributeEdit'),
      meta: {
        auth: true,
        pageTitle: 'Izmena atributa',
        breadcrumb: [
          {title: 'Atribut', link: '/attributes'},
          {title: 'Izmena atributa'}
        ]
      }
    },

    // Tags CRUD
    {
      path: '/tags',
      component: require('./views/tags/TagList.vue'),
      meta: {
        auth: true,
        pageTitle: 'Tagovi',
        breadcrumb: [
          {title: 'Tag'}
        ]
      }
    },
    {
      path: '/tags/create',
      component: require('./views/tags/TagCreate.vue'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje tagova',
        breadcrumb: [
          {title: 'Tag', link: '/tags'},
          {title: 'Kreiranje tagova'}
        ]
      }
    },
    {
      path: '/tags/:id/edit',
      component: require('./views/tags/TagEdit.vue'),
      meta: {
        auth: true,
        pageTitle: 'Izmena tagova',
        breadcrumb: [
          {title: 'Tag', link: '/tags'},
          {title: 'Izmena taga'}
        ]
      }
    },

    // Product CRUD
    {
      path: '/products',
      component: require('./views/products/ProductList.vue'),
      meta: {
        auth: true,
        pageTitle: 'Proizvodi',
        breadcrumb: [
          {title: 'Proizvod'}
        ]
      }
    },
    {
      path: '/products/create',
      component: require('./views/products/ProductCreate.vue'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje proizvoda',
        breadcrumb: [
          {title: 'Proizvod', link: '/products'},
          {title: 'Kreiranje proizvoda'}
        ]
      }
    },
    {
      path: '/products/:id/edit',
      component: require('./views/products/ProductEdit.vue'),
      meta: {
        auth: true,
        pageTitle: 'Izmena proizvoda',
        breadcrumb: [
          {title: 'Proizvod', link: '/products'},
          {title: 'Izmena proizvoda'}
        ]
      }
    },

    // Permission CRUD
    {
      path: '/permissions',
      component: require('./views/permissions/PermissionList'),
      meta: {
        auth: true,
        pageTitle: 'Dozvole',
        breadcrumb: [
          {title: 'Dozvola'}
        ]
      }
    },
    {
      path: '/permissions/create',
      component: require('./views/permissions/PermissionCreate'),
      meta: {
        auth: true,
        pageTitle: 'Kreiranje dozvole',
        breadcrumb: [
          {title: 'Dozvola', link: '/permissions'},
          {title: 'Kreiranje dozvole'}
        ]
      }
    },
    {
      path: '/permissions/:id/edit',
      component: require('./views/permissions/PermissionEdit'),
      meta: {
        auth: true,
        pageTitle: 'Editovanje dozvole',
        breadcrumb: [
          {title: 'Dozvole', link: '/permissions'},
          {title: 'Editovanje dozvole'},
        ]
      }
    }
  ]
});