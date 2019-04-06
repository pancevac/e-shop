<template>
  <div>
    <card
        class='stripe-card'
        :class='{ complete }'
        :stripe='stripeKey'
        :options='stripeOptions'
        @change='change($event)'
    ></card>
    <div id="card-errors" role="alert" v-text="errorMessage" style="color: red"></div>
    <!--<button class='pay-with-stripe' @click='pay' :disabled='!complete'>Pay with credit card</button>-->
  </div>
</template>

<script>
  import {Card, createToken} from 'vue-stripe-elements-plus'

  export default {
    name: "StripePaymentForm",

    data() {
      return {
        complete: false,
        errorMessage: null,
        stripeKey: 'pk_test_5FAtwwh0ZcPmbyvtGMwSKkVB',
        stripeOptions: {
          // see https://stripe.com/docs/stripe.js#element-options for details
          hidePostalCode: true,
          base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
          }
        }
      }
    },

    components: {Card},

    methods: {
      pay() {
        // createToken returns a Promise which resolves in a result object with
        // either a token or an error key.
        // See https://stripe.com/docs/api#tokens for the token object.
        // See https://stripe.com/docs/api#errors for the error object.
        // More general https://stripe.com/docs/stripe.js#stripe-create-token.
        createToken().then(data => {
          // Emit stripe token to parent component
          this.$emit('token', data.token);
        })
      },

      change(event) {
        if (event.error) {
          this.errorMessage = event.error.message;
        }
      }
    }
  }
</script>

<style>
  .StripeElement {
    background-color: white;
    height: 40px;
    padding: 10px 12px;
    border-radius: 4px;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
  }

  .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }

  .StripeElement--invalid {
    border-color: #fa755a;
  }

  .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
  }
</style>
