<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Informacije o narudžbini</h5>
            <hr>

            <p><b>ID narudžbine:</b> {{ order.id }}</p>

            <p><b>ID transakcije:</b> {{ order.transaction_identifier }}</p>

            <p><b>Kreirana:</b> {{ order.created_at }}</p>

            <p v-if="order.status === 'success'"><b>Status:</b> Uspešna</p>
            <p v-if="order.status === 'failed'"><b>Status:</b> Neuspešna</p>

            <p v-if="order.error"><b>Kod greške:</b> {{ order.error }}</p>

            <p v-if="order.status === 'success'"><b>Ukupno:</b> {{ formatPrice(order.total_price) }}</p>
            <br>

            <h5 class="card-title m-b-0">Informacije o kupcu</h5>
            <hr>

            <p v-if="order.customer"><b>Kupac:</b> {{ order.customer.first_name }}
              {{ order.customer.last_name }} <b>Email:</b> {{ order.email }}</p>

            <p v-else><b>Email adresa kupca:</b> {{ order.email }}</p>

            <p><b>Broj telefona:</b> {{ order.phone }}</p>

            <p><b>Zemlja:</b> {{ order.country }}</p>

            <p><b>Grad:</b> {{ order.city }}</p>

            <p><b>Poštanski broj:</b> {{ order.postal_code }}</p>

            <p><b>Adresa:</b> {{ order.address1 }}</p>

            <p v-if="order.address2"><b>Sekundarna adresa:</b> {{ order.address2 }}</p>

            <p><b>Broj telefona:</b> {{ order.phone }}</p>

            <p><b>Napomena kupca:</b> {{ order.note }}</p>

            <checkbox-field
                label="Plaćeno"
                v-model="order.is_paid"
            ></checkbox-field>

            <checkbox-field
                label="Isporučeno"
                v-model="order.is_delivered"
            ></checkbox-field>

            <br>

            <h5 class="card-title m-b-0">Kupljeni proizvodi</h5>
            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Šifra proizvoda</th>
                <th scope="col">Količina</th>
                <th scope="col">Cena proizoda</th>
                <th scope="col">Cena proizvoda * količina</th>
                <th scope="col">Akcije</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in order.products">
                <td><a href="#" @click.prevent="goToProduct(row.id)">{{ row.title }}</a></td>
                <td>{{ row.code }}</td>
                <td>{{ row.pivot.qty }}</td>
                <td>{{ formatPrice(row.pivot.price / row.pivot.qty) }}</td>
                <td>{{ formatPrice(row.pivot.price) }}</td>
                <td><a class="btn btn-cyan btn-sm" :href="row.link" target="_blank">Pregled</a></td>
              </tr>
              </tbody>
            </table>

            <br>
            <p
                v-if="order.status === 'success' && order.coupon"
            ><b>Iskorišćen kupon:</b> {{ order.coupon.code }} (sniženje {{ order.coupon.discount }}%)</p>

            <p v-if="order.status === 'success'"><b>Ukupno:</b> {{ formatPrice(order.total_price) }}</p>

          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click.prevent="update">Izmeni</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import accounting from 'accounting';

  export default {
    name: "OrderPreview",

    data() {
      return {
        order: {},
      }
    },

    mounted() {
      this.getOrder();
    },

    methods: {

      getOrder() {
        axios.get('api/orders/' + this.$route.params.id + '/edit')
          .then(response => {
            this.order = response.data.order;
          })
      },

      update() {
        axios.put('api/orders/' + this.$route.params.id, this.order)
          .then(response => {
            this.$toasted.global.toastSuccess({ message: response.data.message });
          })
      },

      goToProduct(id) {
        this.$router.push('/products/' + id + '/edit');
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