<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Tip menija</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Publikovano</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in menus">
                <td>{{ row.title }}</td>
                <td v-if="row.visible">Da</td><td v-else>Ne</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="goTo(row['id'])">Link</button>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getMenus"></pagination>

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
    name: "MenuList",

    data() {
      return {
        menus: [],
        paginate: {},
      }
    },

    components: {
      pagination
    },

    mounted() {
      this.getMenus();
    },

    methods: {
      getMenus(page = 1) {
        axios.get('api/menus?page=' + page)
          .then(res => {
            this.menus = res.data.menus.data;
            this.paginate = res.data.menus;
          })
      },

      goTo(id) {
        this.$router.push('menu-links/' + id);
      },

      editRow(id) {
        this.$router.push('menus/' + id + '/edit');
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
            axios.delete('api/menus/' + id)
              .then(res => {
                this.$toasted.global.toastSuccess({ message: res.data.message })
                this.getMenus();
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