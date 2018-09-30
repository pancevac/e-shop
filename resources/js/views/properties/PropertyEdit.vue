<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Nova osobina</h4>

            <select-multiple-field
                :options="categories"
                label="Kategorije"
                :value="property.categories"
                @input="selectedCategories = $event"
                optionLabel="title"
                trackBy="id"
            ></select-multiple-field>

            <text-field
                label="Naziv"
                :required=true
                v-model="property.title"
                :error="error? error.title : ''"
            ></text-field>

            <text-field
                label="Redosled"
                :required=true
                v-model="property.order"
                :error="error? error.order : ''"
            ></text-field>

            <text-field
                label="Dodatak"
                v-model="property.additional"
                :error="error? error.additional : ''"
            ></text-field>

            <checkbox-field
                label="Publikovano"
                v-model="property.publish"
            ></checkbox-field>

          </div>

          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Izmeni</button>
            </div>
          </div>

        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <h5>Vezani atributi</h5>
            <ul class="list-group">
              <li class="list-group-item" v-for="attribute in property.attributes">
                <span>{{ attribute.title }}</span>
                <router-link tag="a" :to="'/attributes/' + attribute.id + '/edit'" class="btn btn-primary">Izmeni</router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  export default {
    name: "PropertyEdit",
    data() {
      return {
        property: {},
        categories: [],
        selectedCategories: [],
        error: null,
      }
    },

    mounted() {
      this.getCategories();
      this.getProperty();
    },

    methods: {
      getCategories() {
        axios.get('api/categories/lists')
          .then(res => {
            this.categories = res.data.categories;
          })
      },

      getProperty() {
        axios.get('api/properties/' + this.$route.params.id + '/edit')
          .then(res => {
            this.property = res.data.property;
          })
      },

      submit() {
        this.property.categories = this.selectedCategories;
        axios.put('api/properties/' + this.$route.params.id, this.property)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/properties');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      }
    }
  }
</script>

<style lang="scss" scoped>
  .list-group-item{
    display: flex;

    span{
      flex: 1;
    }
  }
</style>