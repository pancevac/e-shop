<template>
  <div>

    <div class="p_icon" v-if="pageType === 'shop'">
      <a href="#" @click.prevent="addToWishList">
        <i class="lnr lnr-heart"></i>
      </a>
      <a href="#" @click.prevent="addToShoppingCart">
        <i class="lnr lnr-cart"></i>
      </a>
    </div>

    <div class="card_area" v-if="pageType === 'single-product'">
      <a class="main_btn" href="#" @click.prevent="addToShoppingCart">Dodaj u korpu</a>
      <a class="icon_btn" href="#" @click.prevent="addToWishList">
        <i class="lnr lnr lnr-heart"></i>
      </a>
    </div>

  </div>
</template>

<script>
  export default {
    name: "ShoppingCart",

    props: {
      pageType: {
        type: String
      },
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
        if (this.pageType === 'single-product') {
          this.cart.qty = document.getElementById('sst').value;
        }

        axios.post(this.productUrl + '/shoppingCart', this.cart)
          .then(response => {
            this.$toasted.global.toastDefault({ message: response.data.message });
            // Update cart items counter
            this.$store.dispatch('cart/changeShoppingCartCount', response.data.cartItemsCount);
          })
          .catch(e => {
            this.$toasted.global.toastError();
          })
      },

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
    }
  }
</script>