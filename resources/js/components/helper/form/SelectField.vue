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

    props: {
      options: {
        type: Array,
      },
      value: {
        type: [Object, String, Number],
        default: null,
      },
      label: {
        type: String,
      },
      required: {
        type: Boolean,
        default: false
      },
      error: {
        type: [Object, Array, String],
        default: null,
      },
      optionLabel: {
        type: String,
        default: null,
      },
      trackBy: {
        type: String,
        default: null,
      },
    },

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
        else if (this.checkOptionsType) {
          this.$emit('input', value[this.trackBy]); // value[] is not array but object and we can access property name
                                                    // just like it is array element
        }
        else {
          this.$emit('input', value);
        }
      },

    },
    computed: {
      isInvalid() {
        if (this.error != null && this.error)
          return true;
      },

      /**
       * Check if options array contain objects or just strings
       *
       * @returns {boolean}
       */
      checkOptionsType() {
        if (this.trackBy !== null || this.optionLabel !== null) {
          return true;
        }
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