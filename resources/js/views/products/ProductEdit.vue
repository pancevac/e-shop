<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Novi proizvod</h4>

            <select-field
                    v-if="!isLoading"
                    :options="brands"
                    label="Brend"
                    :value="product.brand"
                    @input="product.brand_id = $event"
                    optionLabel="title"
                    trackBy="id"
                    :required=true
                    :error="error? error.brand_id : ''"
            ></select-field>

            <text-field
                    label="Naziv"
                    :required=true
                    v-model="product.title"
                    :error="error? error.title : ''"
            ></text-field>

            <text-field
                    label="Slug"
                    v-model="product.slug"
                    :error="error? error.slug : ''"
            ></text-field>

            <text-field
                    label="Šifra"
                    :required=true
                    v-model="product.code"
                    :error="error? error.code : ''"
            ></text-field>

            <text-area-field
                    label="Kratak opis"
                    v-model="product.short"
                    :error="error? error.short : ''"
            ></text-area-field>

            <!-- Ovde ide EDITOR komponenta -->

            <text-field
                    label="Cena"
                    v-model="product.price"
                    :error="error? error.price : ''"
            ></text-field>

            <text-field
                    label="Outlet cena"
                    v-model="product.price_outlet"
                    :error="error? error.price_outlet : ''"
            ></text-field>

            <select-multiple-field
                    :options="tags"
                    label="Tagovi"
                    :value="product.tags"
                    @input="product.selectedTags = $event"
                    optionLabel="title"
                    trackBy="id"
            ></select-multiple-field>

            <checkbox-field
                    label="Publikovano"
                    v-model="product.publish"
            ></checkbox-field>

            <div class="row">
              <div class="col-sm-6">
                <date-field
                        v-model="product.date"
                        label="Objavi od datuma"
                ></date-field>
              </div>
              <div class="col-sm-6">
                <time-field
                        v-model="product.time"
                        label="Od sati"
                ></time-field>
              </div>
            </div>

          </div>

          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Unesi</button>
            </div>
          </div>

        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <tree-select
                    v-model="product.selectedCategories"
                    :options="categories"
                    label="Kategorije"
                    :error="error? error.selectedCategories : ''"
            ></tree-select>

          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import TreeSelect from '../../components/helper/form/TreeSelect.vue';
  import DateField from '../../components/helper/form/DateField.vue';
  import TimeField from '../../components/helper/form/TimeField.vue';
  import moment from 'moment';

  export default {
    data() {
      return {
        product: {
          selectedCategories: [],
        },
        brands: [],
        tags: [],
        categories: [],
        error: null,
        loading: true,
      }
    },

    components: {
      'tree-select': TreeSelect,
      'date-field': DateField,
      'time-field': TimeField,
    },

    computed: {
      publish_at(){
        return this.product.date + ' ' + this.product.time
      },
      isLoading() {
        return this.loading;
      }
    },

    mounted() {
      this.getBrands();
      this.getCategories();
      this.getTags();
      this.getProduct();
    },

    methods: {
      getProduct() {
        axios.get('api/products/' + this.$route.params.id + '/edit')
          .then(res => {
            this.product = res.data.product;
            this.product.selectedCategories = res.data.product.categoriesIds;
            this.loading = false;
          })
      },

      getBrands() {
        axios.get('api/brands/lists')
          .then(res => {
            this.brands = res.data.brands;
          })
      },

      getCategories() {
        axios.get('api/categories/sort')
          .then(res => {
            this.categories = res.data.categories;
          })
      },

      getTags() {
        axios.get('api/tags/lists')
          .then(res => {
            this.tags = res.data.tags;
          })
      },

      submit() {
        this.product.user_id = this.$store.getters['user/getUser'].id;
        this.product.publish_at = this.publish_at;

        axios.put('api/products/' + this.$route.params.id, this.product)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/products');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      }
    }
  }
</script>