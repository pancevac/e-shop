<template>
  <div class="billing_details">
    <div class="row">
      <div class="col-lg-8">
        <h3>Detalji kupovine</h3>
        <form class="row contact_form" action="#" method="post" novalidate="novalidate">
          <div class="col-md-6 form-group p_star">
            <input v-model="form.first_name" type="text" class="form-control" id="first" name="name">
            <span class="placeholder" data-placeholder="Ime"></span>
          </div>
          <div class="col-md-6 form-group p_star">
            <input v-model="form.last_name" type="text" class="form-control" id="last" name="name">
            <span class="placeholder" data-placeholder="Prezime"></span>
          </div>
          <div class="col-md-6 form-group p_star">
            <input v-model="form.phone" type="text" class="form-control" id="number" name="number">
            <span class="placeholder" data-placeholder="Broj telefona"></span>
          </div>
          <div class="col-md-6 form-group p_star">
            <input v-model="form.email" v-if="!user" type="text" class="form-control" id="email" name="email">
            <input v-model="form.email" v-else  type="text" class="form-control" id="email" name="email" disabled>
            <span class="placeholder" data-placeholder="Email adresa"></span>
          </div>
          <div class="col-md-12 form-group p_star">
            <select class="country_select" v-model="form.country">
              <option value="Srbija">Srbija</option>
              <option value="Makedonija">Makedonija</option>
            </select>
          </div>
          <div class="col-md-12 form-group p_star">
            <input v-model="form.address1" type="text" class="form-control" id="add1" name="add1">
            <span class="placeholder" data-placeholder="Adresa 1"></span>
          </div>
          <div class="col-md-12 form-group p_star">
            <input v-model="form.address2" type="text" class="form-control" id="add2" name="add2">
            <span class="placeholder" data-placeholder="Adresa 2"></span>
          </div>
          <div class="col-md-12 form-group p_star">
            <input v-model="form.city" type="text" class="form-control" id="city" name="city">
            <span class="placeholder" data-placeholder="Opština/Grad"></span>
          </div>
          <div v-model="form.zip" class="col-md-12 form-group">
            <input type="text" class="form-control" id="zip" name="zip" placeholder="Poštanski broj/ZIP">
          </div>
          <div class="col-md-12 form-group">
            <div class="creat_account">
              <h3>Napomena</h3>
            </div>
            <textarea v-model="form.note" class="form-control" name="message" id="message" rows="1" placeholder="Napišite napomenu ovde"></textarea>
          </div>
        </form>
      </div>
      <div class="col-lg-4">
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
      </div>
    </div>
  </div>
</template>

<script>
  import stripe from './StripePaymentFIeld';

  export default {
    name: "CheckoutForm",

    props: ['cartItems', 'subTotal', 'total', 'discount', 'coupon', 'user'],

    components: { stripe },

    data() {
      return {
        form: {
          first_name: null,
          last_name: null,
          phone: null,
          email: null,
          country: null,
          address1: null,
          address2: null,
          city: null,
          zip: null,
          note: null,
          token: null,

        },

        stripeToken: null,
        conditionAccepted: false,
        sent: false,
      }
    },

    mounted() {
      this.fillForm();
    },

    methods: {
      pay() {
        if (this.conditionAccepted) {
          this.$refs.stripe.pay();
        }
      },

      response(token) {
        this.form.token = token;
        this.charge();
      },

      charge() {
        if (this.sent === false) {
          this.sent = true;
          axios.post('/checkout', this.form)
            .then(response => {
              //
            }).catch(e => {
            console.log(e);
          })
        }
      },

      fillForm() {
        if (this.user) {
          this.form.first_name = this.user.customer.first_name;
          this.form.last_name = this.user.customer.last_name;
          this.form.phone = this.user.customer.phone;
          this.form.address1 = this.user.customer.address1;
          this.form.address2 = this.user.customer.address2;
          this.form.city = this.user.customer.city;
          this.form.country = this.user.customer.city;
          this.form.email = this.user.email;
          this.form.zip = this.user.customer.zip;
        }
      }
    },


  }
</script>
