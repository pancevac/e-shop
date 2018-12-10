<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Kupci</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">ID kupca</th>
                <th scope="col">Ime</th>
                <th scope="col">Prezime</th>
                <th scope="col">Email</th>
                <th scope="col">Blokiran</th>
                <th scope="col">Registrovan</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in customers">
                <td>{{ row.id }}</td>
                <td>{{ row.first_name }}</td>
                <td>{{ row.last_name }}</td>
                <td>{{ row.user.email }}</td>
                <td v-if="row.user.block">Da</td><td v-else>Ne</td>
                <td>{{ row.created_at }}</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getCustomers"></pagination>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Pagination from 'laravel-vue-pagination';
  import Swal from 'sweetalert2';

  export default {
    name: "CustomerList",

    data() {
      return {
        customers: [],
        paginate: null,
      }
    },

    components: {
      Pagination
    },

    mounted() {
      this.getCustomers();
    },

    methods: {

      getCustomers(page = 1) {
        axios.get('api/customers/?page=' + page)
          .then(response => {
            this.customers = response.data.customers.data;
            this.paginate = response.data.customers;
          })
          .catch(e => {
            console.log(e);
          })
      },

      editRow(id) {
        this.$router.push('customers/' + id + '/edit');
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
              axios.delete('api/customers/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getCustomers();
                })
                .catch(e => {
                  this.$toasted.global.toastError({
                    message: e.response.data.message
                  });
                })
            }
          })
      },
    },
  }
</script>