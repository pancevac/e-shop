<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Narudžbine</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">ID narudžbine</th>
                <th scope="col">Korisnik</th>
                <th scope="col">Ukupna cena</th>
                <th scope="col">Isporučeno</th>
                <th scope="col">Plaćeno</th>
                <th scope="col">Kreirano</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in orders">
                <td>{{ row.id }}</td>
                <td v-if="row.customer">{{ row.customer.first_name }} {{ row.customer.last_name }}</td>
                <td v-else>/</td>
                <td>{{ formatPrice(row.total_price) }}</td>
                <td v-if="row.is_delivered">Da</td><td v-else>Ne</td>
                <td v-if="row.is_paid">Da</td><td v-else>Ne</td>
                <td>{{ row.created_at }}</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getOrders"></pagination>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Pagination from 'laravel-vue-pagination';
  import Swal from 'sweetalert2';
  import accounting from 'accounting';

  export default {
    name: "OrderList",

    components: {
      Pagination
    },

    data() {
      return {
        orders: [],
        paginate: {},
      }
    },

    mounted() {
      this.getOrders();
    },

    methods: {

      getOrders(page = 1) {

        axios.get('api/orders/?page=' + page)
          .then(response => {
            this.orders = response.data.orders.data;
            this.paginate = response.data.orders;
          })
          .catch(e => {
            console.log(e);
          })
      },

      editRow(id) {
        this.$router.push('orders/' + id + '/edit');
      },

      deleteRow(id) {
        Swal({
          title: 'Da li ste sigurni?',
          text: 'Nećete moći da povratite akciju!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Obriši!',
          cancelButtonText: 'Otkaži'
        })
          .then((result) => {
            if (result.value) {
              axios.delete('api/orders/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getOrders();
                })
                .catch(e => {
                  this.$toasted.global.toastError({
                    message: e.response.data.message
                  });
                })
            }
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