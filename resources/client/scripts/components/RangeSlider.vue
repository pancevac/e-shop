<template>
  <div>
    <vue-slider
        ref="slider"
        v-model="value"
        v-bind="options"
        @drag-end="submit"
    ></vue-slider>
    <label>Cena od: {{ value[0] }} do: {{ value[1] }}</label>
    <input type="hidden" name="price[]" :value="value[0]"/>
    <input type="hidden" name="price[]" :value="value[1]"/>
  </div>
</template>

<script>
  // Used only in vue2.x version
  import vueSlider from 'vue-slider-component'
  // or
  // import vueSlider from 'vue-slider-component/src/vue2-slider.vue'

  export default {

    name: "RangeSlider",

    components: { vueSlider },

    props: ['min', 'max', 'minSelected', 'maxSelected'],

    data() {
      return {
        value: [parseInt(this.minSelected), parseInt(this.maxSelected)],
        options: {
          min: parseInt(this.min),
          max: parseInt(this.max),
          tooltip: 'hover',
        }
      }
    },

    methods: {

      submit(val) {
        document.getElementById('filters').submit();
        //this.$emit('submit', this.value);
      },

    }

  }
</script>