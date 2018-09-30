<template>
  <div class="form-group row">
    <label :for="label" class="col-sm-3 text-right control-label col-form-label">{{ label }}
    </label>

    <div class="col-md-9">
      <multi-select
              v-model="selected"
              :options="options"
              :close-on-select="true"
              :allow-empty="true"
              placeholder="Izaberi"
              :label="optionLabel"
              :track-by="trackBy"
              v-bind:class="{ 'is-invalid': isInvalid }"
      ></multi-select>

      <small class="form-text text-muted" v-if="isInvalid">{{ error[0] }}</small>

    </div>
  </div>
</template>

<script>
  import MultiSelect from 'vue-multiselect';
  export default {
    data() {
      return {
        selected: this.value,
        lists: this.options,
      }
    },
    props: ['options', 'value', 'label', 'required', 'error', 'optionLabel', 'trackBy'],
    components: { MultiSelect },
    methods: {
      //
    },
    watch: {
      // value(value, oldValue) {
      //   this.selected = this.value;
      // },
      selected(value) {
        if (value == null) {
          this.$emit('input', 0);
        }
        else {
          this.$emit('input', value.id);
        }
      }
    },
    computed: {
      isInvalid() {
        if (this.error != null && this.error)
          return true;
      },

      // model: {
      //   get() {
      //     return this.value
      //   },
      //   set(val) {
      //     this.$emit('input', val.id)
      //   }
      // }
    }
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
  .text-muted { color: red !important; }
</style>