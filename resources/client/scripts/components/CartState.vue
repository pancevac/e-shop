<template><div></div></template>

<script>
  export default {

    name: "CartState",

    props: [
      'cartItemsProp',
      'cartCountProp',
      'cartTotalPriceProp',
      'cartSubtotalPriceProp',
      'couponProp'
      //'cartTotalDiscountProp',
    ],

    created() {

      this.$store.dispatch('cart/changeCartItems', this.cartItemsProp);
      this.$store.dispatch('cart/changeItemCount', this.cartCountProp);
      this.$store.dispatch('cart/changeSubTotalPrice', this.cartSubtotalPriceProp);
      this.$store.dispatch('cart/changeTotalPrice', this.cartTotalPriceProp);
      this.$store.dispatch('cart/changeCoupon', this.couponProp);
      //this.$store.dispatch('changeDiscount', this.cartTotalDiscountProp);

    },

  }
</script>