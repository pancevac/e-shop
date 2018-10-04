<template>
  <div class="form-group">
    <label>{{ label }} <span v-if="required">*</span></label>

    <ckeditor
        v-model="content"
        :config="config"
        @input="$emit('input', $event)"
    ></ckeditor>

    <small class="form-text text-muted" v-if="isInvalid">{{ error[0] }}</small>
  </div>
</template>

<script>
  import Ckeditor from 'vue-ckeditor2';

  export default {
    name: "CkeditorField",
    components: { Ckeditor },
    data() {
      return {
        content: this.value,
        config: {
          toolbar: [
            [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'Image', 'Link', 'Unlink', 'Source' ],
            { name: 'insert', items: ['Table', 'SpecialChar', 'Videoembed'] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
            '/',
            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
          ],
          height: 300,
          filebrowserBrowseUrl: 'filemanager/show'
        },
      }
    },

    props: ['label', 'value', 'required', 'error'],

    computed: {
      isInvalid() {
        if (this.error != null && this.error)
          return true;
      },
    }
  }
</script>

<style scoped>
  .text-muted {
    color: red !important;
  }
</style>