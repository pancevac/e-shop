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
      component: require('./components/partials/Dashboard'),
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
        permission: 'user.view',
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
        permission: 'user.create',
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
        permission: 'user.update',
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
        permission: 'brand.view',
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
        permission: 'brand.create',
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
        permission: 'brand.update',
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
        permission: 'category.view',
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
        permission: 'category.create',
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
        permission: 'category.update',
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
        permission: 'category.update',
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
        permission: 'property.view',
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
        permission: 'property.create',
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
        permission: 'property.update',
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
        permission: 'attribute.view',
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
        permission: 'attribute.create',
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
        permission: 'attribute.update',
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
        permission: 'tag.view',
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
        permission: 'tag.create',
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
        permission: 'tag.update',
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
        permission: 'product.view',
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
        permission: 'product.create',
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
        permission: 'product.update',
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
        permission: 'permission.view',
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
        permission: 'permission.create',
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
        permission: 'permission.update',
        pageTitle: 'Editovanje dozvole',
        breadcrumb: [
          {title: 'Dozvole', link: '/permissions'},
          {title: 'Editovanje dozvole'},
        ]
      }
    },

    // Role CRUD
    {
      path: '/roles',
      component: require('./views/roles/RoleList'),
      meta: {
        permission: 'role.view',
        pageTitle: 'Lista uloga',
        breadcrumb: [
          {title: 'Uloge'}
        ],
      }
    },
    {
      path: '/roles/create',
      component: require('./views/roles/RoleCreate'),
      meta: {
        permission: 'role.create',
        pageTitle: 'Kreiranje uloge',
        breadcrumb: [
          {title: 'Uloga', link: '/roles'},
          {title: 'Kreiranje uloge'},
        ]
      }
    },
    {
      path: '/roles/:id/edit',
      component: require('./views/roles/RoleEdit'),
      meta: {
        permission: 'role.update',
        pageTitle: 'Izmena uloge',
        breadcrumb: [
          {title: 'Uloga', link: '/roles'},
          {title: 'Izmena uloge'},
        ]
      }
    },

    // Menu CRUD
    {
      path: '/menus',
      component: require('./views/menus/MenuList'),
      meta: {
        permission: 'menu.view',
        pageTitle: 'Lista tipova menija',
        breadcrumb: [
          {title: 'Tip menija'}
        ]
      }
    },
    {
      path: '/menus/create',
      component: require('./views/menus/MenuCreate'),
      meta: {
        permission: 'menu.create',
        pageTitle: 'Kreiranje tipa menija',
        breadcrumb: [
          {title: 'Tip menija', link: '/menus'},
          {title: 'Kreiranje tipa menija'}
        ]
      }
    },
    {
      path: '/menus/:id/edit',
      component: require('./views/menus/MenuEdit'),
      meta: {
        permission: 'menu.update',
        pageTitle: 'Izmena tipa menija',
        breadcrumb: [
          {title: 'Tip menija', link: '/menus'},
          {title: 'Izmena tipa menija'}
        ]
      }
    },

    // Menu-link CRUD
    {
      path: '/menu-links/:id',
      component: require('./views/menuLinks/MenuLinkList'),
      meta: {
        permission: 'menuLink.view',
        pageTitle: 'Lista linkova',
        breadcrumb: [
          {title: 'Tip menija', link: '/menus'},
          {title: 'Link'}
        ]
      }
    },
    {
      path: '/menu-links/:id/create',
      component: require('./views/menuLinks/MenuLinkCreate'),
      meta: {
        permission: 'menuLink.create',
        pageTitle: 'Kreiranje linka',
        breadcrumb: [
          {title: 'Tip menija', link: '/menus'},
          {title: 'Link', link: '/menu-links?id=' + this.id},
          {title: 'Kreiranje linka'}
        ]
      }
    },
    {
      path: '/menu-links/:id/edit',
      component: require('./views/menuLinks/MenuLinkEdit'),
      meta: {
        permission: 'menuLink.update',
        pageTitle: 'Izmena linka',
        breadcrumb: [
          {title: 'Tip menija', link: '/menus'},
          {title: 'Link', link: '/menu-links?id=' + this.id},
          {title: 'Izmena linka'}
        ]
      }
    },
    {
      path: '/menu-links/:id/sort',
      component: require('./views/menuLinks/MenuLinkSort'),
      meta: {
        permission: 'menuLink.update',
        pageTitle: 'Izmena linka',
        breadcrumb: [
          {title: 'Tip menija', link: '/menus'},
          {title: 'Link', link: '/menu-links?id=' + this.id},
          {title: 'Sortiranje linkova'}
        ]
      }
    },

    // Coupon
    {
      path: '/coupons',
      component: require('./views/coupons/CouponList'),
      meta: {
        permission: 'coupon.view',
        pageTitle: 'Kuponi',
        breadcrumb: [
          {title: 'Kuponi'},
        ],
      },
    },
    {
      path: '/coupons/create',
      component: require('./views/coupons/CouponCreate'),
      meta: {
        permission: 'coupon.create',
        pageTitle: 'Kreiranje kupona',
        breadcrumb: [
          {title: 'Kuponi', link: '/coupons'},
          {title: 'Kreiranje kupona'}
        ],
      },
    },
    {
      path: '/coupons/:id/edit',
      component: require('./views/coupons/CouponEdit'),
      meta: {
        permission: 'coupon.update',
        pageTitle: 'Izmena kupona',
        breadcrumb: [
          {title: 'Kuponi', link: '/coupons'},
          {title: 'Izena kupona'}
        ],
      },
    },

    // Orders
    {
      path: '/orders',
      component: require('./views/orders/OrderList'),
      meta: {
        permission: 'order.view',
        pageTitle: 'Narudžbine',
        breadcrumb: [
          {title: 'Narudžbine'},
        ],
      },
    },
    {
      path: '/orders/:id/edit',
      component: require('./views/orders/OrderPreview'),
      meta: {
        permission: 'order.update',
        pageTitle: 'Pregled narudžbine',
        breadcrumb: [
          {title: 'Narudžbine', link: '/orders'},
          {title: 'Pregled narudžbine'},
        ],
      },
    },

    // Customers
    {
      path: '/customers',
      component: require('./views/customers/CustomerList'),
      meta: {
        permission: 'customer.view',
        pageTitle: 'Kupci',
        breadcrumb: [
          {title: 'Kupci'},
        ],
      },
    },
    {
      path: '/customers/:id/edit',
      component: require('./views/customers/CustomerEdit'),
      meta: {
        permission: 'customer.update',
        pageTitle: 'Izmena kupca',
        breadcrumb: [
          {title: 'Kupci', link: '/customers'},
          {title: 'Izmena kupca'},
        ],
      },
    },

    // Widgets
    {
      path: '/widgets',
      component: require('./views/widgets/WidgetList'),
      meta: {
        permission: 'widget.view',
        pageTitle: 'Widžeti',
        breadcrumb: [
          {title: 'Widžeti'},
        ],
      },
    },
    {
      path: '/widgets/create',
      component: require('./views/widgets/WidgetCreate'),
      meta: {
        permission: 'widget.create',
        pageTitle: 'Kreiranje Widžeta',
        breadcrumb: [
          {title: 'Widžeti', link: '/widgets'},
          {title: 'Kreiranje Widžeta'}
        ]
      }
    },
    {
      path: '/widgets/:id/edit',
      component: require('./views/widgets/WidgetsEdit'),
      meta: {
        permission: 'widget.update',
        pageTitle: 'Izmena Widžeta',
        breadcrumb: [
          {title: 'Widžeti', link: '/widgets'},
          {title: 'Izmena Widžeta'}
        ]
      }
    },

    // Banners
    {
      path: '/banners',
      component: require('./views/banners/BannerList'),
      meta: {
        permission: 'banner.view',
        pageTitle: 'Baneri',
        breadcrumb: [
          {title: 'Baneri'},
        ]
      }
    },
    {
      path: '/banners/create',
      component: require('./views/banners/BannerCreate'),
      meta: {
        permission: 'banner.create',
        pageTitle: 'Kreiranje banera',
        breadcrumb: [
          {title: 'Baneri', link: '/banners'},
          {title: 'Kreiranje banera'}
        ]
      }
    },
    {
      path: '/banners/:id/edit',
      component: require('./views/banners/BannerEdit'),
      meta: {
        permission: 'banner.update',
        pageTitle: 'Izmena banera',
        breadcrumb: [
          {title: 'Banneri', link: '/banners'},
          {title: 'Izmena Banera'}
        ]
      }
    }
  ]
});