<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Tagovi</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Slug</th>
                <th scope="col">Publikovano</th>
                <th scope="col">Kreirano</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in tags">
                <td>{{ row.title }}</td>
                <td>{{ row.slug }}</td>
                <td v-if="row.publish">Da</td>
                <td v-else>Ne</td>
                <td>{{ row.created_at }}</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getTags"></pagination>

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
        tags: {},
        paginate: {},
      }
    },

    components: {
      Pagination
    },

    mounted() {
      this.getTags();
    },

    methods: {
      getTags(page = 1) {
        axios.get('api/tags?page=' + page)
          .then(res => {
            this.tags = res.data.tags.data;
            this.paginate = res.data.tags;
          })
      },

      editRow(id) {
        this.$router.push('tags/' + id + '/edit');
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
                  this.$toasted.global.toastSuccess({message: res.data.message});
                  this.getTags();
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