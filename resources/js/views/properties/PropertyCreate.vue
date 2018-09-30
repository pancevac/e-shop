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
              <button type="button" class="btn btn-primary" @click="submit">Unesi</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "PropertyCreate",
    data() {
      return {
        property: {
          slug: null,
        },
        categories: {},
        selectedCategories: '',
        error: null,
      }
    },

    mounted() {
      this.getCategories();
    },

    methods: {
      getCategories() {
        axios.get('api/categories/lists')
          .then(res => {
            this.categories = res.data.categories;
          })
      },

      submit() {
        this.property.categories = this.selectedCategories;
        axios.post('api/properties', this.property)
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