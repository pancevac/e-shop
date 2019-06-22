<template>
  <aside class="left-sidebar" data-sidebarbg="skin5" :class="{ 'hide': ! user }">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
        <ul id="sidebarnav" class="p-t-30">
          <li class="sidebar-item"> <router-link :to="'/home'" class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Početna</span></router-link></li>

          <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Podešavanja </span></a>
            <ul v-if="user" aria-expanded="false" class="collapse  first-level">
              <li v-if="can('menu.view')" class="sidebar-item"><router-link :to="'/menus'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Meni </span></router-link></li>
              <li v-if="can('banner.view')" class="sidebar-item"><router-link :to="'/banners'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Baneri </span></router-link></li>
              <li v-if="can('widget.view')" class="sidebar-item"><router-link :to="'/widgets'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Widžeti </span></router-link></li>
            </ul>
          </li>

          <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Korisici </span></a>
            <ul v-if="user" aria-expanded="false" class="collapse  first-level">
              <li v-if="can('user.view')" class="sidebar-item"><router-link :to="'/users'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Korisnici </span></router-link></li>
              <li v-if="can('permission.view')" class="sidebar-item"><router-link :to="'/permissions'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Dozvole </span></router-link></li>
              <li v-if="can('role.view')" class="sidebar-item"><router-link :to="'/roles'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Uloge </span></router-link></li>
            </ul>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
              <i class="mdi mdi-account-key"></i>
              <span class="hide-menu">Prodavnica </span>
            </a>
            <ul v-if="user" aria-expanded="false" class="collapse  first-level">
              <li v-if="can('product.view')" class="sidebar-item"><router-link :to="'/products'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Proizvodi </span></router-link></li>
              <li v-if="can('order.view')" class="sidebar-item"><router-link :to="'/orders'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Narudžbine </span></router-link></li>
              <li v-if="can('customer.view')" class="sidebar-item"><router-link :to="'/customers'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Kupci </span></router-link></li>
              <li v-if="can('coupon.view')" class="sidebar-item"><router-link :to="'/coupons'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Kuponi </span></router-link></li>
              <li v-if="can('brand.view')" class="sidebar-item"><router-link :to="'/brands'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Brendovi </span></router-link></li>
              <li v-if="can('category.view')" class="sidebar-item"><router-link :to="'/categories'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Kategorije </span></router-link></li>
              <li v-if="can('property.view')" class="sidebar-item"><router-link :to="'/properties'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Osobine </span></router-link></li>
              <li v-if="can('attribute.view')" class="sidebar-item"><router-link :to="'/attributes'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Atributi </span></router-link></li>
              <li v-if="can('tag.view')" class="sidebar-item"><router-link :to="'/tags'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Tagovi </span></router-link></li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>
</template>

<script>
  export default {
    name: "LeftBar",

    computed: {
      user() {
        return this.$store.getters['user/getUser'];
      }
    }
  }
</script>
