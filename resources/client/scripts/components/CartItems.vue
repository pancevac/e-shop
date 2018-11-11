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

    <tr v-for="(item, index) in items">
      <td>
        <div class="media">
          <div class="d-flex">
            <img :src="item.model.cartProductImage" alt="">
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
              v-model="items[index].qty"
              type="text"
              name="qty"
              id="qty"
              maxlength="12"
              title="Quantity:"
              class="input-text qty"
              @keyup.enter="updateShoppingCart(index)"
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
        <a class="gray_btn" href="#">Update Cart</a>
      </td>
      <td>

      </td>
      <td>

      </td>
      <td>
        <div class="cupon_text">
          <input type="text" placeholder="Coupon Code">
          <a class="main_btn" href="#">Apply</a>
          <a class="gray_btn" href="#">Close Coupon</a>
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
        <h5>$2160.00</h5>
      </td>
    </tr>
    <tr class="shipping_area">
      <td>

      </td>
      <td>

      </td>
      <td>
        <h5>Shipping</h5>
      </td>
      <td>
        <div class="shipping_box">
          <ul class="list">
            <li>
              <a href="#">Flat Rate: $5.00</a>
            </li>
            <li>
              <a href="#">Free Shipping</a>
            </li>
            <li>
              <a href="#">Flat Rate: $10.00</a>
            </li>
            <li class="active">
              <a href="#">Local Delivery: $2.00</a>
            </li>
          </ul>
          <h6>Calculate Shipping
            <i class="fa fa-caret-down" aria-hidden="true"></i>
          </h6>
          <select class="shipping_select">
            <option value="1">Bangladesh</option>
            <option value="2">India</option>
            <option value="4">Pakistan</option>
          </select>
          <select class="shipping_select">
            <option value="1">Select a State</option>
            <option value="2">Select a State</option>
            <option value="4">Select a State</option>
          </select>
          <input type="text" placeholder="Postcode/Zipcode">
          <a class="gray_btn" href="#">Update Details</a>
        </div>
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
  export default {
    name: "CartItems",

    props: ['cartItems', 'subTotal', 'total', 'tax'],

    data() {
      return {
        items: {},
      }
    },

    created() {
      this.items = this.cartItems;
    },

    computed: {

    },

    methods: {
      /**
       * Increase items quantity, send request to backend
       *
       * @param index
       */
      increaseQuantity(index) {
        this.items[index].qty++;
        this.updateShoppingCart(index);
      },

      /**
       * Reduce items quantity, send request to backend
       *
       * @param index
       */
      reduceQuantity(index) {
        this.items[index].qty--;
        this.updateShoppingCart(index);
      },

      /**
       * Return product total price multiple by product quantity
       *
       * @param index
       * @returns {number}
       */
      totalPerProduct(index) {
        return this.items[index].price * this.items[index].qty;
      },

      /**
       * Update Shopping cart by sending request to backend
       *
       * @param index
       */
      updateShoppingCart(index) {
        let item = this.items[index];
        axios.post('/korpa/update', { qty: item.qty, rowId: item.rowId })
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
       * Remove item from shopping cart
       *
       * @param index
       */
      removeItem(index) {
        let item = this.items[index];

        axios.post('/korpa/delete', { rowId: item.rowId })
          .then(response => {
            // Delete item from items object
            this.removeFromObject(index);
            // Set toast message
            this.$toasted.global.toastDefault({ message: response.data.message });
            // Update cart items counter
            this.$store.dispatch('cart/changeShoppingCartCount', response.data.cartItemsCount);
          })
          .catch(e => {
            this.$toasted.global.toastError();
          })
      },

      /**
       * Remove item from object items...
       *
       * @param index
       */
      removeFromObject(index) {
        this.items = Object.keys(this.items).reduce((object, key) => {
          if (key !== index) {
            object[key] = this.items[key]
          }
          return object
        }, {});
      }
    }
  }
</script>
