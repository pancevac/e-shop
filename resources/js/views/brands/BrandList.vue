<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Brendovi</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Ime</th>
                <th scope="col">Publikovan</th>
                <th scope="col">Kreirano</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in brands">
                <td>{{ row.title }}</td>
                <td v-if="row.publish">Da</td><td v-else>Ne</td>
                <td>{{ row.created_at }}</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getBrands"></pagination>

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
    data() {
      return {
        brands: {},
        paginate: {},
      }
    },

    components: {
      Pagination
    },

    mounted() {
      this.getBrands();
    },

    methods: {
      getBrands(page = 1) {
        axios.get('api/brands/?page=' + page)
          .then(res => {
            this.brands = res.data.brands.data;
            this.paginate = res.data.brands;
          })
          .catch(e => {
            console.log(e);
          })
      },

      editRow(id) {
        this.$router.push('brands/' + id + '/edit');
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
              axios.delete('api/brands/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getBrands();
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