<template>
  <li class="nav-item">
    <a :href="shoppingCartLink" class="icons">
      <i class="lnr lnr lnr-cart"></i>{{ getItemsCount }}
    </a>
  </li>
</template>

<script>
  export default {
    name: "ShoppingCartCounter",

    props: {
      cartItemsCount: {
        type: Number,
        default: null,
      },
      shoppingCartLink: {
        type: String,
      }
    },

    created() {
      // Set initial value of items count in shopping-cart in vuex store...
      this.$store.dispatch('cart/changeShoppingCartCount', this.cartItemsCount);
    },

    computed: {
      // Get currently number of items in cart
      getItemsCount() {
        let counter = this.$store.getters['cart/getShoppingCartCount'];
        if (counter > 0) return counter;
      }
    },

    methods: {
      //
    }
  }
</script>