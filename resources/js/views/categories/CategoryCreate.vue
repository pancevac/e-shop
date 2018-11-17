<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje kategorije</h4>

            <text-field
                label="Naziv"
                :required=true
                v-model="category.title"
                :error="error? error.title : ''"
            ></text-field>

            <text-field
                label="Slug (frendly-url)"
                v-model="category.slug"
                :error="error? error.slug : ''"
            ></text-field>

            <text-field
                label="Redosled"
                v-model="category.order"
                :error="error? error.order : ''"
            ></text-field>

            <text-field
                label="Seo naziv"
                v-model="category.seo_title"
                :error="error? error.seo_title : ''"
            ></text-field>

            <text-field
                label="Seo ključne reči"
                v-model="category.seo_keywords"
                :error="error? error.seo_keywords : ''"
            ></text-field>

            <text-field
                label="Seo opis"
                v-model="category.seo_description"
                :error="error? error.seo_description : ''"
            ></text-field>

          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="card">
          <div class="card-body">

            <select-field
                v-if="!isLoading"
                :options="categories"
                label="Nad kategorija"
                @input="category.parent = $event"
                optionLabel="title"
                trackBy="id"
                :error="error? error.parent : ''"
            ></select-field>

            <checkbox-field
                label="Istaknuta"
                v-model="category.featured"
            ></checkbox-field>

            <checkbox-field
                label="Publikovana"
                v-model="category.publish"
            ></checkbox-field>

            <upload-image-helper
                :image="category.image"
                :defaultImage="null"
                :titleImage="'kategorije'"
                :error="error ? error.image : ''"
                @uploadImage="prepareImage($event)"
                @removeRow="remove($event)"
            ></upload-image-helper>

          </div>

          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Unesi</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import UploadImageHelper from '../../components/helper/UploadImageHelper';

  export default {

    components: { UploadImageHelper },

    data() {
      return {
        category: {
          slug: '',
          parent: null,
        },
        error: null,
        categories: [],
        loading: true,
      }
    },

    computed: {
      isLoading() {
        return this.loading;
      }
    },

    mounted() {
      this.getCategoriesList();
    },

    methods: {
      getCategoriesList() {
        axios.get('api/categories/lists')
          .then(res => {
            this.categories = res.data.categories;
            this.loading = false;
          })
          .catch(e => {
            console.log(e);
          })
      },

      prepareImage(image) {
        this.category.image = image.src;
        this.formData = new FormData();
        this.formData.append('image', image.file);
        this.$toasted.global.toastSuccess({
          message: 'Slika je setovana.'
        });
      },

      uploadImage() {
        axios.post('api/categories/' + this.category.id + '/uploadImage', this.formData)
          .then(res => {
            this.category.image = res.data.image;
            this.error = null
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },

      submit() {
        axios.post('api/categories', this.category)
          .then(res => {
            this.category = res.data.category;
            this.uploadImage();
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/categories');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      }
    },
  }
</script>