<template>
  <div class="form-group row">
    <label :for="label" class="col-sm-3 text-right control-label col-form-label">{{ label }} <span v-if="required">*</span>
    </label>
    <div class="col-sm-9">
      <textarea
              class="form-control"
              :value="value"
              @input="$emit('input', $event.target.value)"
              :id="label"
              :placeholder="placeholder"
              v-bind:class="{ 'is-invalid': isInvalid }"
      ></textarea>
      <div class="invalid-feedback" v-if="isInvalid">
        {{ error[0] }}
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['label', 'value', 'error', 'required', 'placeholder'],
    computed: {
      isInvalid() {
        if (this.error != null && this.error)
          return true;
      }
    }
  }
</script>

<style scoped>
  span { color: red; }
</style>