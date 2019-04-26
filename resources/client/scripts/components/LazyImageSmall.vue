<template>
  <v-lazy-image
      class="img-fluid"
      :src="src"
      :placeholder="placeholder"
      alt="alt"
  ></v-lazy-image>
</template>

<script>
  import vLazyImage from "v-lazy-image";

  export default {

    name: "LazyImage",

    props: ['src', 'alt', 'placeholder'],

    components: { vLazyImage },
  }

</script>

<style scoped>
  .v-lazy-image {
    opacity: 0;
    transition: opacity 0.7s;
    position: absolute;
    top: 50%;
    left: 14%;
    max-width: 70px;
    height: auto;
    /*width: auto;*/
    -webkit-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
  }
  .v-lazy-image-loaded {
    opacity: 1;
  }
</style>