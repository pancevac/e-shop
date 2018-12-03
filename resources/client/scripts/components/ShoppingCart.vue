<template>
  <table class="table">
    <thead>
    <tr>
      <th scope="col">Proizvod</th>
      <th scope="col">Cena</th>
      <th scope="col">Količina</th>
      <th scope="col">Ukupno</th>
      <th scope="col">Akcija</th>
    </tr>
    </thead>
    <tbody>

    <tr v-for="(item, index) in cartItems">
      <td>
        <div class="media">
          <div class="d-flex">
            <a :href="item.model.link">
              <img :src="item.model.cartProductImage" alt="">
            </a>
          </div>
          <div class="media-body">
            <p>{{ item.name }}</p>
          </div>
        </div>
      </td>
      <td>
        <h5>${{ item.price }}</h5>
      </td>
      <td>
        <div class="product_count">
          <input
              v-model="cartItems[index].qty"
              type="text"
              name="qty"
              id="qty"
              maxlength="12"
              title="Quantity:"
              class="input-text qty"
              @keyup.enter="updateShoppingCart(cartItems[index])"
          >
          <button type="button" class="increase items-count" @click="increaseQuantity(index)">
            <i class="lnr lnr-chevron-up"></i>
          </button>

          <button type="button" class="reduced items-count" @click="reduceQuantity(index)">
            <i class="lnr lnr-chevron-down"></i>
          </button>

        </div>
      </td>
      <td>
        <h5>${{ totalPerProduct(index) }}</h5>
      </td>
      <td>
        <a href="#" @click.prevent="removeItem(index)">
          <i class="lnr lnr-cross-circle"></i>
        </a>
      </td>
    </tr>

    <tr class="bottom_button">
      <td>
        <a class="gray_btn" href="#">Nastavite kupovinu</a>
      </td>
      <td>

      </td>
      <td>

      </td>
      <td>
        <div class="cupon_text">
          <input type="text" placeholder="Coupon Code" v-model="coupon" style="margin-left: 150px; margin-right: 10px;">
          <a class="main_btn" href="#" @click="submitCoupon">Primeni</a>
          <!--<a class="gray_btn" href="#">Close Coupon</a>-->
        </div>
      </td>
    </tr>
    <tr>
      <td>

      </td>
      <td>

      </td>
      <td>
        <h5>Subtotal</h5>
      </td>
      <td>
        <h5>${{ formatPrice(getSubTotalPrice) }}</h5>
      </td>
    </tr>

    <tr>
      <td>

      </td>
      <td>

      </td>
      <td>
        <h5>Total</h5>
      </td>
      <td>
        <h5>${{ formatPrice(getTotalPrice) }}</h5>
      </td>
    </tr>


    <tr class="out_button_area">
      <td>

      </td>
      <td>

      </td>
      <td>

      </td>
      <td>
        <div class="checkout_btn_inner">
          <a class="gray_btn" href="#">Continue Shopping</a>
          <a class="main_btn" href="#">Proceed to checkout</a>
        </div>
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
  import accounting from 'accounting';

  export default {
    name: "ShoppingCart",

    props: {
      cartItemsProp: {
        type: Object,
      },
      subTotalProp: {
        type: String,
      },
      totalProp: {
        type: String,
      }
    },

    data() {
      return {
        cartItems: [],
        subTotal: null,
        total: null,
        coupon: null,
      }
    },

    created() {
      // Set cart items, sub and total prices
      this.cartItems = this.cartItemsProp;
      this.subTotal = this.subTotalProp;
      this.total = this.totalProp;
    },

    computed: {

      /**
       * Retrieve cart items
       */
      getCartItems() {
        return this.cartItems;
      },

      /**
       * Retrieve cart items sub-total price
       */
      getSubTotalPrice() {
        return this.subTotal;
      },

      /**
       * Retrieve cart items total price
       */
      getTotalPrice() {
        return this.total;
      },
    },

    methods: {

      totalPerProduct(index) {
        return this.cartItems[index].price * this.cartItems[index].qty;
      },

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

            // Set success notification
            this.$toasted.global.toastDefault({ message: response.data.message });

            // Update vuex store
            this.$store.dispatch('cart/changeItemCount', response.data.cartItemsCount);

            // Update cartItems
            this.cartItems = response.data.cartItems;
            this.subTotal = response.data.subTotal;
            this.total = response.data.total;
          })
          .catch(e => {
            // Error
            console.log(e);
          })
      },

      /**
       * Remove item from shopping cart
       */
      removeItem(index) {
        let item = this.getCartItems[index];
        axios.delete('/korpa/' + item.rowId)
          .then(response => {

            // Set success notification
            this.$toasted.global.toastDefault({ message: response.data.message });

            // Update vuex store
            this.$store.dispatch('cart/changeItemCount', response.data.cartItemsCount);

            // Update cartItems
            this.cartItems = response.data.cartItems;
            this.subTotal = response.data.subTotal;
            this.total = response.data.total;
          })
          .catch(e => {

          })
      },

      /**
       * Submit coupon and set new total price
       */
      submitCoupon() {
        axios.post('korpa/kupon', {coupon: this.coupon})
          .then(response => {
            this.$toasted.global.toastDefault({ message: response.data.message });
            this.total = response.data.total;
          })
          .catch(e => {
            this.$toasted.global.toastError({ message: e.response.data.errors });
          })
      },

      /**
       * Format price euro.
       *
       * @param value
       */
      formatPrice(value) {
        return accounting.formatMoney(value, '', 2, '.', ',')
      },



    },
  }
</script>
