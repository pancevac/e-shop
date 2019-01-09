<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje Banera</h4>

            <text-field
                    label="Tekst dugmeta"
                    v-model="banner.button_text"
                    :error="error? error.button_text : ''"
            ></text-field>

            <text-field
                    label="Link dugmeta"
                    :required=true
                    v-model="banner.link"
                    :error="error? error.link: ''"
            ></text-field>

            <ckeditor
                    label="Tekst slike"
                    v-model="banner.image_text"
                    :error="error? error.image_text : ''"
            ></ckeditor>

            <upload-image-helper
                    :image="banner.image"
                    :defaultImage="null"
                    :titleImage="'Banera'"
                    :error="error ? error.image : ''"
                    @uploadImage="prepareImage($event)"
                    @removeRow="remove($event)"
            ></upload-image-helper>

            <checkbox-field
                    label="Aktivan"
                    v-model="banner.active"
            ></checkbox-field>

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
  import Ckeditor from '../../components/helper/form/CkeditorField';

  export default {
    name: "BannerCreate",

    components: { UploadImageHelper, Ckeditor },

    data() {
      return {
        banner: {
          image: null,
          image_text: null,
          link: null,
          button_text: null,
          active: false,
        },
        error: null,
      }
    },

    methods: {

      prepareImage(image) {
        this.banner.image = image.src;
        this.formData = new FormData();
        this.formData.append('image', image.file);
        this.$toasted.global.toastSuccess({
          message: 'Slika je setovana.'
        });
      },

      uploadImage() {
        axios.post('api/banners/' + this.banner.id + '/uploadImage', this.formData)
          .then(res => {
            this.banner.image = res.data.image;
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
        axios.post('api/banners', this.banner)
          .then(response => {
            this.banner = response.data.banner;
            this.uploadImage();
            this.$toasted.global.toastSuccess({ message: response.data.message });
            this.$router.push('/banners');
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