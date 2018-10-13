<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Static Table</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Korisničko ime</th>
                <th scope="col">Email</th>
                <th scope="col">Uloga</th>
                <th scope="col">Blokiran</th>
                <th scope="col">Kreiran</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in users">
                <td>{{ row.name }}</td>
                <td>{{ row.email }}</td>
                <td v-if="row.role">{{ row.role.title }}</td><td v-else>/</td>
                <td v-if="row.block">Da</td><td v-else>Ne</td>
                <td>{{ row.created_at }}</td>
                <td>
                  <i class="fas fa-pencil-alt" @click="editRow(row['id'])"></i>
                  <i class="fas fa-times" @click="deleteRow(row['id'])"></i>
                </td>
              </tr>
              </tbody>
            </table>

            <!--<paginate-helper :paginate="paginate" @clickLink="clickToLink($event)"></paginate-helper>-->
            <pagination :data="paginate" @pagination-change-page="getUsers"></pagination>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import PaginateHelper from '../../components/helper/PaginationHelper.vue';
  import Swal from 'sweetalert2';
  import pagination from 'laravel-vue-pagination';

  export default {
    data() {
      return {
        users: {},
        paginate: {},
      }
    },

    components: {
      'paginate-helper': PaginateHelper,
      pagination,
    },

    mounted() {
      this.getUsers();
    },

    methods: {

      getUsers(page = 1) {
        axios.get('api/users?page=' + page)
            .then(res => {
              this.users = res.data.users.data;
              this.paginate = res.data.users;
            })
            .catch(e => {
              console.log(e)
            })
      },

      /*clickToLink(index){
        axios.get('api/users?page=' + index)
            .then(res => {
              this.users = res.data.users.data;
              this.paginate = res.data.users;
            })
            .catch(e => {
              console.log(e);
            });
      },*/

      editRow(id) {
        this.$router.push('users/' + id + '/edit');
      },

      deleteRow(id) {
        Swal({
          title: 'Da li ste sigurni?',
          text: 'Nećete moći da povratite korisnika!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Obriši!',
          cancelButtonText: 'Otkaži'
        }).then((result) => {
          if (result.value) {
            axios.delete('api/users/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message })
                  this.getUsers();
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