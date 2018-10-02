<template>
  <div class="form-group m-t-20">
    <label>{{ label }}</label>

    <treeselect
            v-model="model"
            :multiple="true"
            :options="optionsList"
            value-consists-of="ALL_WITH_INDETERMINATE"
    ></treeselect>

    <small class="form-text text-muted" v-if="isInvalid">{{ error[0] }}</small>
  </div>
</template>

<script>
  import Treeselect from '@riophae/vue-treeselect'
  import '@riophae/vue-treeselect/dist/vue-treeselect.css'

  export default {
    data() {
      return {
        optionsList: this.options,
      }
    },

    props: ['value', 'options', 'label', 'error'],

    computed: {
      model: {
        get() {
          return this.value
        },
        set(value) {
          this.$emit('input', value)
        }
      },

      isInvalid() {
        if (this.error !== null && this.error)
          return true;
      },
    },

    watch: {
      options(value) {
        this.optionsList = value;
      }
    },

    components: {
      Treeselect
    }
  }
</script>

<style scoped>
  .text-muted {
    color: red !important;
  }
</style>