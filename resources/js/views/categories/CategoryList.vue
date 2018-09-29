<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Kategorije</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Nad kategorija</th>
                <th scope="col">Publikovano</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in categories">
                <td>{{ row.title }}</td>
                <td v-if="row.parent_category">{{ row.parent_category.title }}</td><td v-else>Bez</td>
                <td v-if="row.publish">Da</td><td v-else>Ne</td>
                <td>
                  <i class="fas fa-pencil-alt" @click="editRow(row['id'])"></i>
                  <i class="fas fa-times" @click="deleteRow(row['id'])"></i>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getCategories"></pagination>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import pagination from 'laravel-vue-pagination';
  import Swal from 'sweetalert2';

  export default {
    data() {
      return {
        categories: {},
        paginate: {},
      }
    },

    components: {
      pagination
    },

    mounted() {
      this.getCategories();
    },

    methods: {
      getCategories(page = 1) {
        axios.get('api/categories?page=' + page)
          .then(res => {
            this.categories = res.data.categories.data;
            this.paginate = res.data.categories;
          })
          .catch(e => {
            console.log(e);
          })
      },

      editRow(id) {
        this.$router.push('categories/' + id + '/edit');
      },

      deleteRow(id) {
        Swal({
          title: 'Da li ste sigurni?',
          text: 'Nećete moći da povratite akciju!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Obriši!',
          cancelButtonText: 'Otkaži'
        }).then((result) => {
          if (result.value) {
            axios.delete('api/categories/' + id)
              .then(res => {
                this.$toasted.global.toastSuccess({ message: res.data.message })
                this.getCategories();
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