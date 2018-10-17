<template>
  <div>
    <preloader></preloader>
    <div id="main-wrapper">
      <top-bar></top-bar>
      <left-bar></left-bar>
      <div class="page-wrapper" :class="{ expanded : ! user }">

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
        return this.$store.getters['user/getUser'];
      }
    },

    created() {
      this.storeUser();
    },

    methods: {
      /** Auth **/
      storeUser() {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$auth.getToken();
        if (this.$store.getters['user/getUser'] == null) {
          axios.get('api/user')
            .then(res => {
              if (res.data.role_id < 1) {
                this.$auth.destroyToken();
                this.$router.push('/login');
              }
              else {
                this.$store.dispatch('user/changeUser', res.data);
              }
            })
            .catch(e => {
              if (e.response.status === 401) {
                this.$auth.destroyToken();
                this.$router.push('/login');
              }
            })
        }
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

<style>
  .expanded {
    margin-left: 0 !important;
  }
  .button-add-new {
    margin-bottom: 10px;
  }
</style>