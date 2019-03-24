
<script>
  export default {

    name: "AddToCart",

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
       * Send request for adding product to shopping cart
       */
      addToShoppingCart() {

        let quantity = document.getElementById('product-quantity');

        if (quantity) {
          this.cart.qty = quantity.value;
        }

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