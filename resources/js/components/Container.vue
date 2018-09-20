<template>
  <div>
    <preloader></preloader>
    <div id="main-wrapper">
      <top-bar></top-bar>
      <left-bar></left-bar>
      <div class="page-wrapper">

        <breadcrumb></breadcrumb>

        <page></page>

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