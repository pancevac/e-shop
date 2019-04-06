
<script>
  import stripe from './StripePaymentFIeld';

  export default {
    name: "CheckBox",

    components: { stripe },

    data() {
      return {
        conditionAccepted: false,
        sent: false,
      }
    },

    methods: {

      pay() {
        if (this.conditionAccepted && !this.sent) {
          this.$refs.stripe.pay();
        }
      },

      response(token) {
        document.getElementById('stripeToken').value = JSON.stringify(token);
        this.submitPaymentForm();
      },

      submitPaymentForm() {
        if (this.conditionAccepted) {
          this.sent = true;
          document.getElementById('paymentForm').submit();
        }
      },

    },

  }
</script>
