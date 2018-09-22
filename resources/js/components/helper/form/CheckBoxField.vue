<template>
  <div class="form-group row">
    <label :for="label" class="col-sm-3 text-right control-label col-form-label">{{ label }} <span v-if="required">*</span></label>
    <br>
    <div class="col-sm-9">
      <switches
              v-model="model"
              theme="bootstrap"
              color="primary"
              @input="$emit('input', model ? 1 : 0)"
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
    props: ['label', 'value', 'error', 'required'],
    components: { Switches },
  }
</script>

<style scoped>
  .col-sm-9 {
    padding:10px;
  }
</style>