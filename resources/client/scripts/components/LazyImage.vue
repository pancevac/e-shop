<template>
  <v-lazy-image
      class="img-fluid"
      :src="src"
      :src-placeholder="placeholder"
      alt="alt"
  ></v-lazy-image>
</template>

<script>
  import vLazyImage from "v-lazy-image";

  export default {
    name: "LazyImage",
    props: ['src', 'placeholder', 'alt'],
    components: { vLazyImage }
  }
</script>

<style scoped>
  .v-lazy-image {
    opacity: 0;
    transition: opacity 0.7s;
  }
  .v-lazy-image-loaded {
    opacity: 1;
  }
</style>