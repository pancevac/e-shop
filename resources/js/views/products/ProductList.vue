<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Proizvodi</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Šifra</th>
                <th scope="col">Kategorija</th>
                <th scope="col">Vidljivo</th>
                <th scope="col">Vidljivo od</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in products">
                <td>{{ row.title }}</td>
                <td>{{ row.code }}</td>
                <td v-if="row.categories"><template v-for="category in row.categories"><span class="badge badge-primary" style="margin-right: 3px;">{{ category.title }}</span></template></td><td v-else>/</td>
                <td v-if="row.publish">Da</td><td v-else>Ne</td>
                <td>{{ row.publish_at }}</td>
                <td>
                  <i class="fas fa-pencil-alt" @click="editRow(row.id)"></i>
                  <i class="fas fa-times" @click="deleteRow(row.id)"></i>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getProducts"></pagination>

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
        products: {},
        paginate: {},
      }
    },

    components: {
      Pagination
    },

    mounted() {
      this.getProducts();
    },

    methods: {
      getProducts(page = 1) {
        axios.get('api/products?page=' + page)
          .then(res => {
            this.products = res.data.products.data;
            this.paginate = res.data.products;
          })
      },

      editRow(id) {
        this.$router.push('products/' + id + '/edit');
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
              axios.delete('api/products/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getProducts();
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