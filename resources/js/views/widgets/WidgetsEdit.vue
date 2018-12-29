<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Novi widget</h4>

            <text-field
                    label="Naziv"
                    :required=true
                    v-model="widget.title"
                    :error="error? error.title : ''"
            ></text-field>

            <text-field
                    label="Tekst dugmeta"
                    :required=true
                    v-model="widget.button_text"
                    :error="error? error.order : ''"
            ></text-field>

            <text-field
                    label="Link"
                    v-model="widget.link"
                    :error="error? error.additional : ''"
            ></text-field>

            <checkbox-field
                    label="Aktivan"
                    v-model="widget.active"
            ></checkbox-field>

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
            <upload-image-helper
                    :image="widget.image"
                    :defaultImage="null"
                    :titleImage="'widžeta'"
                    :error="error ? error.image : ''"
                    @uploadImage="prepareImage($event)"
                    @removeRow="remove($event)"
            ></upload-image-helper>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import UploadImageHelper from '../../components/helper/UploadImageHelper';

  export default {

    name: "WidgetsEdit",

    components: { UploadImageHelper },

    data() {
      return {
        widget: {
          title: null,
          button_text: null,
          link: null,
          active: null,
          image: null,
        },
        error: null,
      }
    },

    mounted() {
      this.getProduct();
    },

    methods: {

      getProduct() {
        axios.get('api/widgets/' + this.$route.params.id + '/edit')
          .then(response => {
            this.widget = response.data.widget;
          })
      },

      submit() {
        axios.put('/api/widgets/' + this.$route.params.id, this.widget)
          .then(response => {
            this.widget = response.data.widget;
            this.uploadImage();
            this.$toasted.global.toastSuccess({ message: response.data.message });
            this.$router.push('/widgets');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },

      prepareImage(image) {
        this.widget.image = image.src;
        this.formData = new FormData();
        this.formData.append('image', image.file);
        this.$toasted.global.toastSuccess({
          message: 'Nova slika je importovana.'
        });
      },

      uploadImage() {
        axios.post('api/widgets/' + this.$route.params.id + '/uploadImage', this.formData)
          .then(response => {
            this.widget.image = response.data.image;
            this.error = null
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },

    },
  }
</script>