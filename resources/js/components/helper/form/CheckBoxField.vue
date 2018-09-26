<template>
  <div class="form-group row">
    <label :for="label" class="col-sm-3 text-right control-label col-form-label">{{ label }} <span v-if="required">*</span></label>
    <br>
    <div class="col-sm-9">
      <switches
              v-model="value"
              theme="bootstrap"
              color="primary"
              @input="$emit('input', value)"
      ></switches>
    </div>
  </div>
</template>

<script>
  import Switches from 'vue-switches';
  export default {
    data() {
      return {
        model: this.value,
      }
    },
    props: {
      label: String,
      value: Boolean,
      error: String,
      required: Boolean
    },
    //props: ['label', 'value', 'error', 'required'],
    components: { Switches },
  }
</script>

<style scoped>
  .col-sm-9 {
    padding:10px;
  }
</style>