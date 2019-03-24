<template>
  <a @click.prevent="addToShoppingCart" class="view-btn color-2"><span>Dodaj u korpu</span></a>
</template>

<script>
  export default {

    name: "AddToCart",

    props: {
      /*pageType: {
        type: String
      },*/
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
       * Send request for adding product to shopping cart
       */
      addToShoppingCart() {

        // If loaded page is for single-product, pick selected quantity for product
        /*if (this.pageType === 'single-product') {
          this.cart.qty = document.getElementById('sst').value;
        }*/

        this.cart.qty = document.getElementById('product-quantity').value;

        axios.post(this.productUrl + '/shoppingCart', this.cart)
          .then(response => {
            this.$toasted.global.toastDefault({ message: response.data.message });
            // Update cart items counter
            this.$store.dispatch('cart/changeItemCount', response.data.cartItemsCount);
          })
          .catch(e => {
            this.$toasted.global.toastError();
          })
      },
    }
  }
</script>