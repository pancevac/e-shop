<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">

            <div class="col-md-3">
              <input type="text" class="form-control" placeholder="Pretraga" v-model="search.text">
            </div>

            <div class="col-md-3" v-show="enableList">
              <select class="form-control" v-model="search.option">
                <option :value="index" v-for="(option, index) in lists">{{ option }}</option>
              </select>
            </div>

            <div class="col-md-3">
              <button class="btn btn-primary pull-right" @click.prevent="submit">Pretraži</button>
              <button class="btn bnt-info pull-right" @click.prevent="reset">Resetuj</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {

    props: {
      lists: [Object, Array],
      search: Object,
      enableList: Boolean,
    },

    methods: {
      submit() {
        this.$emit('updateSearch', this.search);
      },

      reset() {
        this.search.text = '';
        this.search.option = 0;
        this.$emit('resetSearch', this.search);
      }
    }

  }
</script>