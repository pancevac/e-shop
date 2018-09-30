<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Osobine</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Publikovano</th>
                <th scope="col">Kategorije</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in properties">
                <td>{{ row.title }}</td>
                <td v-if="row.publish">Da</td><td v-else>Ne</td>
                <td v-if="row.categories">[<template v-for="category in row.categories">{{ category.title }},</template>]</td><td v-else>/</td>
                <td>
                  <i class="fas fa-pencil-alt" @click="editRow(row.id)"></i>
                  <i class="fas fa-times" @click="deleteRow(row.id)"></i>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getProperties"></pagination>

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
    name: "PropertyList",
    data() {
      return {
        properties: {},
        paginate: {},
      }
    },

    components: {
      Pagination
    },

    mounted() {
      this.getProperties();
    },

    methods: {
      getProperties(page = 1) {
        axios.get('api/properties/?page=' + page)
          .then(res => {
            this.properties = res.data.properties.data;
            this.paginate = res.data.properties;
          })
      },

      editRow(id) {
        this.$router.push('properties/' + id + '/edit');
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
              axios.delete('api/properties/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getProperties();
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
