<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">

            <search-helper
                    :lists="properties"
                    :search="searchAttribute"
                    :enableList=true
                    @updateSearch="search($event)"
                    @resetSearch="search($event)"
            ></search-helper>

            <h5 class="card-title m-b-0">Atributi</h5>

            <table class="table">
              <thead>
              <tr>
                <th scope="col">Naziv</th>
                <th scope="col">Osobina</th>
                <th scope="col">Publikovano</th>
                <th scope="col">Akcija</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in attributes">
                <td>{{ row.title }}</td>
                <td>{{ row.property.title }}</td>
                <td v-if="row.publish">Da</td><td v-else>Ne</td>
                <td>
                  <i class="fas fa-pencil-alt" @click="editRow(row.id)"></i>
                  <i class="fas fa-times" @click="deleteRow(row.id)"></i>
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
  import SearchHelper from '../../components/helper/SearchHelper.vue';

  export default {
    name: "AttributeList",
    data() {
      return {
        attributes: {},
        paginate: {},
        properties: {},
      }
    },

    components: {
      Pagination,
      SearchHelper
    },

    computed: {
      searchAttribute() {
        return this.$store.getters['search/getSearchAttribute'];
      }
    },

    mounted() {
      this.getAttributes();
      this.getProperties();
    },

    methods: {
      getAttributes() {
        this.$store.dispatch('search/changeSearchAttributePage', 1);
        axios.post('api/attributes/search', this.searchAttribute)
          .then(res => {
            this.attributes = res.data.attributes.data;
            this.paginate = res.data.attributes;
          })
      },

      getProperties() {
        axios.get('api/properties/lists')
          .then(res => {
            this.properties = res.data.lists;
          })
      },

      editRow(id) {
        this.$router.push('attributes/' + id + '/edit');
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
              axios.delete('api/attributes/' + id)
                .then(res => {
                  this.$toasted.global.toastSuccess({ message: res.data.message });
                  this.getAttributes();
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
        this.$store.dispatch('search/changeSearchAttributePage', 1);
        this.$store.dispatch('search/changeSearchAttribute', value);

        axios.post('api/attributes/search', this.searchAttribute)
          .then(res => {
            this.attributes = res.data.attributes.data;
            this.paginate = res.data.attributes;
          })
          .catch(e => {
            console.log(e);
          })
      },

      clickTolink(page) {
        this.$store.dispatch('search/changeSearchAttributePage', page);
        axios.post('api/attributes/search', this.searchAttribute)
          .then(res => {
            this.attributes = res.data.attributes.data;
            this.paginate = res.data.attributes;
          })
      }
    }
  }
</script>