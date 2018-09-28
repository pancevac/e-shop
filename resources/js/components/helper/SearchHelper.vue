<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">

            <div class="col-md-3">
              <input type="text" class="form-control" placeholder="Pretraga" v-model="search.title">
            </div>

            <div class="col-md-3" v-show="enableList">
              <select class="form-control" v-model="search.option">
                <option :value="index" v-for="(option, index) in lists">{{ option }}</option>
              </select>
            </div>

            <div class="col-md-3">
              <button class="btn btn-primary pull-right" @click.prevent="submit">Pretraži</button>
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
      lists: Object,
      search: Object,
      enableList: Boolean,
    },

    methods: {
      submit() {
        this.$emit('updateSearch', this.value);
      }
    }

  }
</script>