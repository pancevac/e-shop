<template>
  <div class="form-group">
    <label :for="label">{{ label }} <span v-if="required">*</span></label>

    <input type="time" class="form-control" :value="value" :id="label" @input="$emit('input', $event.target.value)" ref="input">

    <small class="form-text text-muted" v-if="isInvalid">{{ error[0] }}</small>
  </div>
</template>

<script>
  export default {

    props: ['value', 'label', 'required', 'error'],

    computed: {
      isInvalid() {
        if (this.error !== null && this.error)
          return true;
      },
    }
  }
</script>

<style scoped>
  .text-muted { color: red !important; }
</style>