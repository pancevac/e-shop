<template>
  <carousel
      class="quick-view-carousel-details"
      items=1
      :loop="true"
      :dots="true"
  >
    <img v-for="image in gallery" class="item" :src="image.gallery_image">
  </carousel>
</template>

<script>
  import carousel from 'vue-owl-carousel'

  export default {

    name: "ProductGallery",

    components: { carousel },

    props: {
      gallery: {
        type: Array,
      }
    },

    data() {
      return {
        domain: window.domain,
      }
    },

  }
</script>