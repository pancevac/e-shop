
<script>
  import CartList from './CartList';
  import accounting from 'accounting';

  export default {

    name: "CartPage",

    components: { CartList },

    data() {
      return {
        coupon: null,
      }
    },

    computed: {

      /**
       * Return total price from cart store
       */
      getTotalPrice() {
        return this.$store.getters['cart/getTotalPrice'];
      },

      getSubTotalPrice() {
        return this.$store.getters['cart/getSubTotalPrice'];
      },

      getDiscountPrice() {
        return this.$store.getters['cart/getDiscountPrice'];
      },

      getCoupon() {
        return this.$store.getters['cart/getCoupon'];
      },

    },

    methods: {

      /**
       * Submit coupon and set new total price
       */
      submitCoupon() {

        if (this.getCoupon) {
          return;
        }

        axios.post('korpa/kupon', {coupon: this.coupon})
          .then(response => {

            this.updateState(response);

          })
          .catch(e => {
            this.$toasted.global.toastError({ message: e.response.data.message });
          })
      },

      /**
       * Remove applied coupon
       */
      removeCoupon() {

        if (! this.getCoupon) {
          return;
        }

        axios.post('korpa/ukloni-kupon')
          .then(response => {
            this.updateState(response);
          })
      },

      updateState(response) {

        // Set success notification
        this.$toasted.global.toastDefault({message: response.data.message});

        // Sync shopping cart state
        this.$store.dispatch('cart/changeCartItems', response.data.cartItems);
        this.$store.dispatch('cart/changeItemCount', response.data.cartItemsCount);
        this.$store.dispatch('cart/changeSubTotalPrice', response.data.subtotalPrice);
        this.$store.dispatch('cart/changeTotalPrice', response.data.totalPrice);
        this.$store.dispatch('cart/changeDiscountPrice', response.data.discountPrice);
        this.$store.dispatch('cart/changeCoupon', response.data.coupon);
      },

      /**
       * Format price euro.
       *
       * @param value
       */
      formatPrice(value) {
        return accounting.formatMoney(value, '', 2, '.', ',');
      },

    },

  }
</script>