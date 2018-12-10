<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Izmena kupca</h5>

            <hr>

            <checkbox-field
                label="Blokiran"
                v-model="block"
            ></checkbox-field>

            <p><b>Ime:</b> {{ customer.first_name }}</p>

            <p><b>Prezime:</b> {{ customer.last_name }}</p>

            <p><b>Email:</b> {{ customer.user.email }}</p>
            <br>

            <h5 class="card-title m-b-0">Ostale informacije</h5>

            <p><b>Adresa 1:</b> {{ customer.address1 }}</p>

            <p v-show="customer.address2"><b>Adresa 1:</b> {{ customer.address2 }}</p>

            <p><b>Grad: </b> {{ customer.city }}</p>

            <p><b>Država:</b> {{ customer.country }}</p>

            <br>

            <h5 class="card-title m-b-0">Narudžbine kupca</h5>
            <table class="table">
              <thead>
              <tr>
                <th scope="col">ID narudžbine</th>
                <th scope="col">ID transakcije</th>
                <th scope="col">Plaćeno</th>
                <th scope="col">Isporučeno</th>
                <th scope="col">Cena</th>
                <th scope="col">Narudžbina napravljena</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in customer.orders">
                <td><a href="#" @click.prevent="goToOrder(row.id)">{{ row.id }}</a></td>
                <td>{{ row.transaction_identifier }}</td>
                <td v-if="row.is_paid">Da</td><td v-else>Ne</td>
                <td v-if="row.is_delivered">Da</td><td v-else>Ne</td>
                <td>{{ row.total_price }}</td>
                <td>{{ row.created_at }}</td>
              </tr>
              </tbody>
            </table>

          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="update">Izmeni</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "CustomerEdit",

    data() {
      return {
        customer: null,
        block: null,
      }
    },

    mounted() {
      this.getCustomer();
    },

    methods: {

      getCustomer() {
        axios.get('api/customers/' + this.$route.params.id + '/edit')
          .then(response => {
            this.customer = response.data.customer;
            this.block = response.data.customer.user.block;
          })
          .catch(e => {
            console.log(e);
          })
      },

      update() {
        axios.put('api/customers/' + this.$route.params.id, {block: this.block})
          .then(response => {
            this.$toasted.global.toastSuccess({ message: response.data.message });
          })
          .catch(e => {
            this.$toasted.global.toastError({ message: e.response.data.message });
          })
      },

      goToOrder(id) {
        this.$router.push('/orders/' + id + '/preview');
      },
    }
  }
</script>