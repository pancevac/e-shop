<template>
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12" v-if="!isGalleryEmpty">
        <div class="card">
          <div class="card-body">
            <h5>Galerija proizvoda</h5>
            <hr>
            <div id="gallery">
              <div v-for="image in gallery" class="photo">
                <i class="fas fa-times" @click="deleteImage(image)"></i>
                <img :src="image.thumbnail" class="img-thumbnail" :alt="product.title" />
              </div>
            </div>
          </div>
        </div>
      </div>

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
            <ckeditor-field
                label="Opis"
                v-model="product.description"
                :error="error? error.description : ''"
            ></ckeditor-field>

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
                @input="trigger($event)"
                :options="categories"
                label="Kategorije"
                valueConsistOf="ALL_WITH_INDETERMINATE"
                :error="error? error.selectedCategories : ''"
            ></tree-select>

            <tree-select
                v-if="properties"
                v-model="product.selectedAttributes"
                label="Osobine i atributi"
                :options="properties"
                :disableBranchNodes="true"
                :showCount="true"
                valueConsistOf="LEAF_PRIORITY"
                :error="error? error.selectedAttributes : ''"
            ></tree-select>

            <image-upload-helper
                :image="product.image"
                :defaultImage="null"
                :titleImage="'proizvoda'"
                :error="error ? error.image : ''"
                @uploadImage="prepareImage($event)"
                @removeRow="remove($event)"
            ></image-upload-helper>

            <vue-dropzone
                ref="myVueDropZone"
                id="dropzone"
                :options="dropzoneOptions"
                @vdropzone-success="showSuccess"
            ></vue-dropzone>

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
  import Ckeditor from '../../components/helper/form/CkeditorField';
  import ImageUploadHelper from '../../components/helper/UploadImageHelper';
  import VueDropZone from 'vue2-dropzone';
  import 'vue2-dropzone/dist/vue2Dropzone.min.css';

  export default {
    data() {
      return {
        product: {
          selectedCategories: [],
          selectedAttributes: [],
          image: null,
          description: null,
        },
        brands: [],
        tags: [],
        categories: [],
        properties: [],
        gallery: [],
        error: null,
        loading: true,
        formData: {},
        dropzoneOptions: {
          url: 'api/products/' + this.$route.params.id + '/uploadGallery',
          thumbnailWidth: 150,
          maxFilesize: 0.5,
          headers: { "Authorization": "Bearer " + this.$auth.getToken() }
        }
      }
    },

    components: {
      'tree-select': TreeSelect,
      'date-field': DateField,
      'time-field': TimeField,
      'ckeditor-field': Ckeditor,
      'image-upload-helper': ImageUploadHelper,
      'vue-dropzone': VueDropZone,
    },

    computed: {
      publish_at() {
        return this.product.date + ' ' + this.product.time
      },

      isLoading() {
        return this.loading;
      },

      watchSelectedCategories() {
        return this.product.selectedCategories;
      },

      isGalleryEmpty() {
        if (this.gallery.length === 0) return true;
      }
    },

    mounted() {
      this.getBrands();
      this.getCategories();
      this.getTags();
      this.getProduct();
      this.getGallery();
    },

    watch: {
      // If selected categories are changed, call method for getting properties
      watchSelectedCategories() {
        this.getProperties();
      }
    },

    methods: {

      // Trigger when selected category is changed cuz stupid watch property doesn't work sometimes...
      trigger(value) {
        this.getProperties();
      },

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

      getProperties() {
        axios.post('api/properties/categories', {categoriesIds: this.product.selectedCategories})
          .then(res => {
            this.properties = res.data.properties;
          })
      },

      getTags() {
        axios.get('api/tags/lists')
          .then(res => {
            this.tags = res.data.tags;
          })
      },

      getGallery() {
        axios.get('api/products/' + this.$route.params.id + '/gallery')
          .then(res => {
            this.gallery = res.data.gallery;
          })
      },

      submit() {
        this.product.user_id = this.$store.getters['user/getUser'].id;
        this.product.publish_at = this.publish_at;

        axios.put('api/products/' + this.$route.params.id, this.product)
          .then(res => {
            this.uploadImage();
            this.$toasted.global.toastSuccess({message: res.data.message});
            this.$router.push('/products');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },

      prepareImage(image) {
        this.product.image = image.src;
        this.formData = new FormData();
        this.formData.append('image', image.file);
        this.$toasted.global.toastSuccess({
          message: 'Nova slika je importovana.'
        });
      },

      uploadImage() {
        axios.post('api/products/' + this.$route.params.id + '/uploadImage', this.formData)
          .then(res => {
            this.product.image = res.data.image;
            this.error = null
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },

      deleteImage(image) {
        axios.delete('api/galleries/' + image.id)
          .then(res => {
            this.gallery = this.gallery.filter(function (item) {
              return image.id !== item.id
            });
            this.$toasted.global.toastSuccess({ message: res.data.message });
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },

      showSuccess() {
        this.getGallery();
      }
    }
  }
</script>

<style scoped>
  .photo {
    display: inline;
    margin-right: 10px;
  }
</style>