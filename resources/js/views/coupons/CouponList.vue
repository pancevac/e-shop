<template>

  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Kuponi</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Kod</th>
                <th scope="col">Popust</th>
                <th scope="col">Preostalo</th>
                <th scope="col">Vazi do</th>
                <td scope="col">Operacije</td>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in coupons">
                <td>{{ row.code }}</td>
                <td>{{ row.discount }}%</td>
                <td>{{ row.amount }}</td>
                <td v-if="row.forever">Neograničeno</td><td v-else>{{ row.valid_until }}</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getCoupons"></pagination>

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
    name: "CouponList",

    components: {
      Pagination
    },

    data() {
      return {
        coupons: [],
      }
    },

    mounted() {
      this.getCoupons();
    },

    methods: {

      getCoupons(page = 1) {
        axios.get('api/coupons/?page=' + page)
          .then(response => {
            this.coupons = response.data.coupons.data;
            this.paginate = response.data.coupons;
          })
          .catch(e => {
            console.log(e);
          })
      },

      editRow(id) {
        this.$router.push('coupons/' + id + '/edit');
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
              axios.delete('api/coupons/' + id)
                .then(response => {
                  this.$toasted.global.toastSuccess({ message: response.data.message });
                  this.getCoupons();
                })
                .catch(e => {
                  this.$toasted.global.toastError({
                    message: e.response.data.message
                  });
                })
            }
          })
      }
    }
  }
</script>

<style scoped>

</style>