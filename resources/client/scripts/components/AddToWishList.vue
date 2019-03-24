<template>
  <a @click.prevent="addToWishList" class="like-btn"><span class="lnr lnr-heart"></span></a>
</template>

<script>
  export default {
    name: "AddToWishList",

    props: {

      productUrl: {
        type: String
      },
      qty: {
        type: Number,
        default: 1
      },
      productCode: {
        type: String,
      },
    },

    data() {
      return {
        domain: domain,
        cart: {
          product: this.productUrl,
          productCode: this.productCode,
          qty: this.qty,
        },
      }
    },

    methods: {

      /**
       * Send request for adding product to wish list
       */
      addToWishList() {
        axios.post(this.domain + 'lista-zelja', this.cart)
          .then(response => {
            this.$toasted.global.toastDefault({ message: response.data.message });
          })
          .catch(e => {
            this.$toasted.global.toastError({ message: e.response.data.message });
          })
      },

    },
  }
</script>