<template>
  <div>
    <preloader></preloader>
    <div id="main-wrapper">
      <top-bar></top-bar>
      <left-bar></left-bar>
      <div class="page-wrapper">

        <breadcrumb></breadcrumb>

        <transition name="fade">
          <router-view></router-view>
        </transition>

        <footer class="footer text-center">
          All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
  export default {

    computed: {
      user() {
        // Get user from store
      }
    },

    created() {
      this.storeUser();
    },

    methods: {
      /** Auth **/
      storeUser() {
        //
      }
    }
  }
</script>
<style>
  .fade-enter-active, .fade-leave-active {
    transition-property: opacity;
    transition-duration: .25s;
  }

  .fade-enter-active {
    transition-delay: .25s;
  }

  .fade-enter, .fade-leave-active {
    opacity: 0
  }
</style>