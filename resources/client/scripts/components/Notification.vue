<script>
  export default {
    name: "Notification",

    props: ['message', 'type'],

    mounted() {
      this.showNotification();
    },

    methods: {

      showNotification() {

        if (this.type == 'success') {
          this.$toasted.global.toastDefault({ message: this.message });
        }
        if (this.type == 'error') {
          this.$toasted.global.toastError({ message: this.message })
        }

      }
    }
  }
</script>