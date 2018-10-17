<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">

            <search-helper
                :lists="categories"
                :enable-list="true"
                :search="searchProduct"
                @updateSearch="search($event)"
                @resetSearch="search($event)"
            ></search-helper>

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
                  <button type="button" class="btn btn-cyan btn-sm" @click="editRow(row['id'])">Izmeni</button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteRow(row['id'])">Obriši</button>
                </td>
              </tr>
              </tbody>
            </table>

            <pagination :data="paginate" @pagination-change-page="clickTolink"></pagination>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Pagination from 'laravel-vue-pagination';
  import Swal from 'sweetalert2';
  import SearchHelper from '../../components/helper/SearchHelper';

  export default {
    data() {
      return {
        products: {},
        paginate: {},
        categories: {},
      }
    },

    components: {
      Pagination,
      SearchHelper
    },

    computed: {
      searchProduct() {
        return this.$store.getters['search/getSearchProduct'];
      }
    },

    mounted() {
      this.getCategories();
      this.getProducts();
    },

    methods: {
      getProducts() {
        this.$store.dispatch('search/changeSearchProductPage', 1);
        axios.post('api/products/search', this.searchProduct)
          .then(res => {
            console.log(res);
            this.products = res.data.products.data;
            this.paginate = res.data.products;
          })
      },

      getCategories() {
        axios.get('api/categories/lists')
          .then(res => {
            this.categories = res.data.lists;
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
      },

      search(value) {
        this.$store.dispatch('search/changeSearchProductPage', 1);
        this.$store.dispatch('search/changeSearchProduct', value);

        axios.post('api/products/search', this.searchProduct)
          .then(res => {
            this.products = res.data.products.data;
            this.paginate = res.data.products;
          })
          .catch(e => {
            console.log(e);
          })
      },

      clickTolink(page) {
        this.$store.dispatch('search/changeSearchProductPage', page);
        axios.post('api/attributes/search', this.searchProduct)
          .then(res => {
            this.products = res.data.products.data;
            this.paginate = res.data.products;
          })
      }
    }
  }
</script>