<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Novi proizvod</h4>

            <select-field
                    :options="brands"
                    label="Brend"
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

            <select-multiple-field
                v-if="properties"
                v-for="(property, index) in properties"
                :key="index"
                :options="property.attributes"
                @input="product.selectedAttributes = product.selectedAttributes.concat($event)"
                :label="property.title"
                optionLabel="title"
                trackBy="id"
            ></select-multiple-field>

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
          slug: null,
          date: moment().format('YYYY-MM-DD'),
          time: moment().format('HH:00'),
          selectedTags: [],
          selectedCategories: [],
          selectedAttributes: [],
        },
        brands: [],
        tags: [],
        categories: [],
        properties: [],
        error: null
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

      watchSelectedCategories() {
        return this.product.selectedCategories;
      },

      removeDuplicateAttributes() {
        return this.product.selectedAttributes.filter((elem, pos, arr) => {
          return arr.indexOf(elem) === pos;
        });
      }
    },

    mounted() {
      this.getBrands();
      this.getCategories();
      this.getTags();
    },

    watch: {
      // If selected categories are changed, call method for getting properties
      watchSelectedCategories(value) {
        this.getProperties()
      },
    },

    methods: {
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

      getProperties() {
        axios.post('api/properties/categories', { categoriesIds: this.product.selectedCategories })
          .then(res => {
            this.properties = res.data.properties;
          })
      },

      submit() {
        this.product.user_id = this.$store.getters['user/getUser'].id;
        this.product.publish_at = this.publish_at;
        this.product.selectedAttributes = this.removeDuplicateAttributes;

        axios.post('api/products', this.product)
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