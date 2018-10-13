<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Uloge</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Aktivna</th>
                <th scope="col">Kreirana</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in roles">
                <td>{{ row.title }}</td>
                <td v-if="row.active">Da</td><td v-else>Ne</td>
                <td>{{ row.created_at }}</td>
                <td>
                  <i class="fas fa-pencil-alt" @click="editRow(row['id'])"></i>
                  <i class="fas fa-times" @click="deleteRow(row['id'])"></i>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getRoles"></pagination>

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
    name: "RoleList",

    data() {
      return {
        roles: [],
        paginate: {},
      }
    },

    components: {
      pagination
    },

    mounted() {
      this.getRoles();
    },

    methods: {

      getRoles(page = 1) {
        axios
          .get('api/roles?page=' + page)
          .then(res => {
            this.roles = res.data.roles.data;
            this.paginate = res.data.roles;
          })
          .catch(e => {
            this.$toasted.global.toastError({ message: e.response.data.message })
          })
      },

      editRow(id) {
        this.$router.push('roles/' + id + '/edit');
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
            axios
              .delete('api/roles/' + id)
              .then(res => {
                this.$toasted.global.toastSuccess({ message: res.data.message })
                this.getRoles();
              })
              .catch(e => {
                this.$toasted.global.toastError({
                  message: e.response.data.message
                });
              })
          }
        })
      }

    },
  }
</script>