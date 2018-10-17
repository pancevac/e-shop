<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">


          <div class="card-body">

            <button
                type="button"
                class="btn btn-cyan btn-sm float-right button-add-new"
                @click="addMenuLink()"
            >Novi link</button>

            <!--<i class="fas fa-plus" @click="addMenuLink()"></i>-->
            <!--<search-helper
                :lists="menus"
                :search="searchMenuLink"
                :enableList=true
                @updateSearch="search($event)"
                @resetSearch="search($event)"
            ></search-helper>-->

            <h5 class="card-title m-b-0">Linkovi menija</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Tip menija</th>
                <th scope="col">Link</th>
                <th scope="col">Aktivan</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in menuLinks">
                <td>{{ row.title }}</td>
                <td>{{ row.menu.title }}</td>
                <td>{{ row.link }}</td>
                <td v-if="row.visible">Da</td><td v-else>Ne</td>
                <td>
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <!--<i class="fas fa-pencil-alt" @click="editRow(row['id'])"></i>-->
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                  <!--<i class="fas fa-times" @click="deleteRow(row['id'])"></i>-->
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="getMenuLinks"></pagination>

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
    name: "MenuLinkList",

    data() {
      return {
        menuLinks: [],
        paginate: {},
      }
    },

    components: {
      pagination,
    },

    mounted() {
      this.getMenuLinks();
    },

    methods: {
      getMenuLinks(page = 1) {
        axios
          .get('api/menu-links?id=' + this.$route.params.id + '&page=' + page)
          .then(res => {
            this.menuLinks = res.data.menuLinks.data;
            this.paginate = res.data.menuLinks;
          })
      },

      editRow(id) {
        this.$router.push('/menu-links/'+ id +'/edit');
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
            axios.delete('api/menu-links/' + id)
              .then(res => {
                this.$toasted.global.toastSuccess({ message: res.data.message })
                this.getMenuLinks();
              })
              .catch(e => {
                this.$toasted.global.toastError({
                  message: e.response.data.message
                });
              })
          }
        })
      },

      addMenuLink() {
        this.$router.push('/menu-links/' + this.$route.params.id + '/create');
      }
    }
  }
</script>