<template>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje kupona</h4>

            <text-field
                label="Kod"
                :required=true
                v-model="coupon.code"
                :error="error? error.code : ''"
            ></text-field>

            <text-field
                label="Popust(%)"
                v-model="coupon.discount"
                :error="error? error.discount : ''"
            ></text-field>

            <text-field
                label="Količina kupona"
                v-model="coupon.amount"
                :error="error? error.amount : ''"
            ></text-field>

            <div class="row">
              <div class="col-sm-6">
                <date-field
                    v-model="publishAt.date"
                    label="Objavi od datuma"
                ></date-field>
              </div>
              <div class="col-sm-6">
                <time-field
                    v-model="publishAt.time"
                    label="Od sati"
                ></time-field>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <date-field
                    v-model="validUntil.date"
                    label="Kupon traje do datuma"
                ></date-field>
              </div>
              <div class="col-sm-6">
                <time-field
                    v-model="validUntil.time"
                    label="Do sati"
                ></time-field>
              </div>
            </div>

            <checkbox-field
                label="Publikovano"
                v-model="coupon.publish"
            ></checkbox-field>

            <checkbox-field
                label="Traje zauvek"
                v-model="coupon.forever"
            ></checkbox-field>

          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Izmeni</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import DateField from '../../components/helper/form/DateField.vue';
  import TimeField from '../../components/helper/form/TimeField.vue';
  import moment from 'moment';

  export default {
    name: "CouponEdit",

    components: {
      'date-field': DateField,
      'time-field': TimeField,
    },

    data() {
      return {
        coupon: {
          code: null,
          discount: null,
          amount: null,
          publish_at: null,
          valid_until: null,
          publish: false,
          forever: false,
        },
        publishAt: {
          date: moment().format('YYYY-MM-DD'),
          time: moment().format('HH:00'),
        },
        validUntil: {
          date: moment().format('YYYY-MM-DD'),
          time: moment().format('HH:00'),
        },
        error: null,
      }
    },

    mounted() {
      this.getCoupon();
    },

    computed: {

      publish_at() {
        return this.publishAt.date + ' ' + this.publishAt.time
      },

      valid_until() {
        return this.validUntil.date + ' ' + this.validUntil.time
      },
    },

    methods: {

      getCoupon() {
        axios.get('api/coupons/' + this.$route.params.id + '/edit')
          .then(response => {
            this.coupon = response.data.coupon;

          })
          .catch(e => {
            console.log(e);
          })
      },

      submit() {
        this.coupon.publish_at = this.publish_at;
        this.coupon.valid_until = this.valid_until;

        axios.put('api/coupons/' + this.$route.params.id, this.coupon)
          .then(response => {
            this.$toasted.global.toastSuccess({ message: response.data.message });
            this.$router.push('/coupons');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      }

    },
  }
</script>

<style scoped>

</style>