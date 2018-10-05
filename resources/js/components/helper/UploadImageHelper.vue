<template>
  <div>
    <div class="form-group row">
      <div class="col-md-9">
        <img v-if="image" :src="image" class="img-fluid" />
        <img v-if="image != null && !image" :src="defaultImage" class="img-fluid" alt="avatar" />
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3">Slika {{ titleImage }}</label>
      <div class="col-md-9">
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="validatedCustomFile" @change="setFileUploader">
          <label class="custom-file-label" for="validatedCustomFile">Izaberite sliku...</label>
          <div class="invalid-feedback">Example invalid custom file feedback</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['image', 'defaultImage', 'titleImage', 'error', 'dimensions'],
    methods: {
      setFileUploader(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        let files = e.target.files;
        if (files.length) {
          reader.readAsDataURL(files[0]);
          reader.onload = (e) => {
            this.$emit('uploadImage', {
              src: e.target.result,
              file: file
            });
          }
        }
      }
    }
  }
</script>