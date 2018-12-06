<template>
  <div class="order_box">
    <h2>Vaša narudžbina</h2>
    <ul class="list">
      <li>
        <a>Proizvodi
          <span>Ukupno</span>
        </a>
      </li>

      <li v-for="(item, index) in cartItems" :key="index">
        <a :href="item.model.link">{{ item.name }}
          <span class="middle">x {{ item.qty }}</span>
          <span class="last">${{ item.price }}</span>
        </a>
      </li>

    </ul>
    <ul class="list list_2">
      <li>
        <a>Ukupno
          <span>${{ subTotal }}</span>
        </a>
      </li>

      <li v-if="coupon">
        <a>Popust sa kuponom({{ coupon.discount }}%)
          <span>-${{ discount }}</span>
        </a>
      </li>

      <li>
        <a>Sveukupno
          <span>${{ total }}</span>
        </a>
      </li>
    </ul>
    <div class="payment_item">
      <div class="radion_btn">
        <input type="radio" id="f-option5" name="selector">
        <label for="f-option5">Check payments</label>
        <div class="check"></div>
      </div>
      <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
    </div>
    <div class="payment_item active">
      <div class="radion_btn">
        <input type="radio" id="f-option6" name="selector">
        <label for="f-option6">Paypal </label>
        <img src="img/product/single-product/card.jpg" alt="">
        <div class="check"></div>
      </div>

      <stripe
          ref="stripe"
          @token="response"
          style="margin-bottom: 20px;"
      ></stripe>

    </div>
    <div class="creat_account">
      <input type="checkbox" id="f-option4" name="selector" v-model="conditionAccepted">
      <label for="f-option4">Pročitao sam i prihvatam navedene </label>
      <a href="#">uslove*</a>
    </div>
    <a class="main_btn" href="#" @click.prevent="pay">Kupi</a>
  </div>
</template>

<script>
  import stripe from './StripePaymentFIeld';

  export default {
    name: "CheckoutForm",

    props: ['cartItems', 'subTotal', 'total', 'discount', 'coupon'],

    components: { stripe },

    data() {
      return {

        stripeToken: null,
        conditionAccepted: false,
        sent: false,
      }
    },

    methods: {
      pay() {
        if (this.conditionAccepted) {
          this.$refs.stripe.pay();
        }
      },

      response(token) {
        document.getElementById('stripeToken').value = token.id;
        this.submitPaymentForm();
      },

      submitPaymentForm() {
        this.sent = true;
        document.getElementById('paymentForm').submit();
      },
    },


  }
</script>
