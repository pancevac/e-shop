<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Widžeti</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Link</th>
                <th scope="col">Tip</th>
                <th scope="col">Redosled</th>
                <th scope="col">Aktivno</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in widgets">
                <td>{{ row.title }}</td>
                <td>{{ row.link }}</td>
                <td>{{ row.type }}</td>
                <td>{{ row.order }}</td>
                <td v-if="row.active">Da</td><td v-else>Ne</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getWidgets"></pagination>

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
    name: "WidgetsList",

    components: {
      Pagination
    },

    data() {
      return {
        widgets: [],
        paginate: {},
      }
    },

    mounted() {
      this.getWidgets();
    },

    methods: {
      getWidgets(page = 1) {
        axios.get('api/widgets/?page=' + page)
          .then(res => {
            this.widgets = res.data.widgets.data;
            this.paginate = res.data.widgets;
          })
      },

      editRow(id) {
        this.$router.push('widgets/' + id + '/edit');
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
              axios.delete('api/widgets/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getWidgets();
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