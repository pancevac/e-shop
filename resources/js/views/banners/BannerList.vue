<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Banneri</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">link</th>
                <th scope="col">aktivan</th>
                <th scope="col">Kreirano</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in banners">
                <td>{{ row.link }}</td>
                <td v-if="row.active">Da</td><td v-else>Ne</td>
                <td>{{ row.created_at }}</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getBanners"></pagination>

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
    name: "BannerList",

    components: { Pagination },

    data() {
      return {
        banners: {},
        paginate: {},
      }
    },

    mounted() {
      this.getBanners();
    },

    methods: {

      getBanners(page = 1) {
        axios.get('api/banners?page=' + page)
          .then(response => {
            this.banners = response.data.banners.data;
            this.paginate = response.data.banners;
          })
      },

      editRow(id) {
        this.$router.push('banners/' + id + '/edit');
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
              axios.delete('api/banners/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getBanners();
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

