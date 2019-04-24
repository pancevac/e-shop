<template>
  <div>
    <div class="cart-single-item" v-for="(item, index) in getCartItems">
      <div class="row align-items-center">
        <div class="col-md-5 col-12">
          <div class="product-item d-flex align-items-center">
            <a :href="item.model.link">
              <img :src="item.model.cartProductImage" class="img-fluid" alt="">
            </a>
            <h6>{{ item.name }}</h6>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="price">{{ item.price_formatted }}</div>
        </div>
        <div class="col-md-2 col-6">
          <div class="quantity-container d-flex align-items-center">

            <input
                v-model="getCartItems[index].qty"
                name="qty"
                id="qty"
                maxlength="12"
                type="text"
                class="quantity-amount"
                @keyup.enter="updateShoppingCart(getCartItems[index])"
            />

            <div class="arrow-btn d-inline-flex flex-column">
              <button class="increase arrow" type="button" title="Increase Quantity" @click="increaseQuantity(index)">
                <span class="lnr lnr-chevron-up"></span>
              </button>
              <button class="decrease arrow" type="button" title="Decrease Quantity" @click="reduceQuantity(index)">
                <span class="lnr lnr-chevron-down"></span>
              </button>
            </div>

          </div>
        </div>
        <div class="col-md-2 col-12">
          <div class="total">{{ item.price_qty_formatted }}</div>
        </div>
        <div class="col-md-1 col-12">
          <a href="#" @click.prevent="removeItem(index)">
            <i class="lnr lnr-cross-circle"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import accounting from 'accounting';

  export default {

    name: "CartList",

    computed: {

      /**
       * Retrieve cart items from cart state
       */
      getCartItems() {
        return this.$store.getters['cart/getCartItems'];
      },
    },

    methods: {

      /**
       * Increase items quantity, send request to backend
       *
       * @param index
       */
      increaseQuantity(index) {
        let item = this.getCartItems[index];
        item.qty++;
        this.updateShoppingCart(item);
      },

      /**
       * Reduce items quantity, send request to backend
       *
       * @param index
       */
      reduceQuantity(index) {
        let item = this.getCartItems[index];
        item.qty--;
        this.updateShoppingCart(item);
      },

      /**
       * Update Shopping cart by sending request to backend
       *
       * @param item
       */
      updateShoppingCart(item) {

        axios.put('/korpa/' + item.rowId, {qty: item.qty})
          .then(response => {

            this.updateState(response);

          })
      },

      /**
       * Remove item from shopping cart
       */
      removeItem(index) {
        let item = this.getCartItems[index];
        axios.delete('/korpa/' + item.rowId)
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
    },

  }
</script>