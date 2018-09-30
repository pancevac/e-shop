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
              :multiple="true"
              placeholder="Izaberi multi"
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
      // Filter ids from array of selected objects
      filterIds() {
        let filteredIds = [];
        if (this.selected) {
          filteredIds = this.selected.map(object => {
            return object.id;
          })
        }
        return filteredIds
      }
    },
    watch: {
      value: function(value, oldValue) {
        this.selected = this.value;
      },
      selected(value) {
        this.$emit('input', this.filterIds());
      }
    },
    computed: {
      isInvalid() {
        if (this.error != null && this.error)
          return true;
      }
    }
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
  .text-muted { color: red !important; }
</style>