<template>
  <aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
        <ul id="sidebarnav" class="p-t-30">
          <li class="sidebar-item"> <router-link :to="'/home'" class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Početna</span></router-link></li>
          <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Korisici </span></a>
            <ul aria-expanded="false" class="collapse  first-level">
              <li class="sidebar-item"><router-link :to="'/users'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Korisnici </span></router-link></li>
            </ul>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
              <i class="mdi mdi-account-key"></i>
              <span class="hide-menu">Prodavnica </span>
            </a>
            <ul aria-expanded="false" class="collapse  first-level">
              <li class="sidebar-item"><router-link :to="'/brands'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Brendovi </span></router-link></li>
              <li class="sidebar-item"><router-link :to="'/categories'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Kategorije </span></router-link></li>
              <li class="sidebar-item"><router-link :to="'/properties'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Osobine </span></router-link></li>
              <li class="sidebar-item"><router-link :to="'/attributes'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Atributi </span></router-link></li>
              <li class="sidebar-item"><router-link :to="'/tags'" href="#" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> Tagovi </span></router-link></li>
            </ul>
          </li>

          <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-alert"></i><span class="hide-menu">Errors </span></a>
            <ul aria-expanded="false" class="collapse  first-level">
              <li class="sidebar-item"><a href="error-403.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 403 </span></a></li>
              <li class="sidebar-item"><a href="error-404.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 404 </span></a></li>
              <li class="sidebar-item"><a href="error-405.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 405 </span></a></li>
              <li class="sidebar-item"><a href="error-500.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 500 </span></a></li>
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
    name: "LeftBar"
  }
</script>

<style scoped>

</style>