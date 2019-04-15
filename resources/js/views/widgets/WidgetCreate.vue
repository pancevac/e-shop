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
                    :error="error? error.button_text : ''"
            ></text-field>

            <text-field
                    label="Link"
                    v-model="widget.link"
                    :error="error? error.link : ''"
            ></text-field>

            <text-field
                label="Redosled"
                v-model="widget.order"
                :error="error? error.order : ''"
            ></text-field>

            <checkbox-field
                    label="Aktivan"
                    v-model="widget.active"
            ></checkbox-field>

          </div>

          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Izmeni</button>
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

    name: "WidgetCreate",

    components: { UploadImageHelper },

    data() {
      return {
        widget: {
          title: null,
          button_text: null,
          link: null,
          order: null,
        },
        error: null,
      }
    },

    methods: {

      prepareImage(image) {
        this.widget.image = image.src;
        this.formData = new FormData();
        this.formData.append('image', image.file);
        this.$toasted.global.toastSuccess({
          message: 'Slika je setovana.'
        });
      },

      uploadImage() {
        axios.post('api/widgets/' + this.widget.id + '/uploadImage', this.formData)
          .then(res => {
            this.widget.image = res.data.image;
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
        axios.post('api/widgets', this.widget)
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
      }
    },
  }
</script>
