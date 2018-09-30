<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Novi atribut</h4>

            <select-field
                v-if="!isLoading"
                :options="properties"
                label="Osobina"
                :value="attribute.property"
                @input="attribute.property_id = $event"
                optionLabel="title"
                trackBy="id"
                :required=true
                :error="error? error.property_id : ''"
            ></select-field>

            <text-field
                label="Naziv"
                :required=true
                v-model="attribute.title"
                :error="error? error.title : ''"
            ></text-field>

            <text-field
                label="Redosled"
                v-model="attribute.order"
                :error="error? error.order : ''"
            ></text-field>

            <text-field
                label="Dodatak"
                v-model="attribute.additional"
                :error="error? error.additional : ''"
            ></text-field>

            <checkbox-field
                label="Publikovano"
                v-model="attribute.publish"
            ></checkbox-field>

          </div>

          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Izmeni</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "AttributeEdit",
    data() {
      return {
        attribute: {},
        properties: [],
        error: null,
        selectedProperty: null,
        loading: true,
      }
    },

    computed: {
      isLoading() {
        return this.loading;
      }
    },

    mounted() {
      this.getProperties();
      this.getAttribute();
    },

    methods: {
      getAttribute() {
        axios.get('api/attributes/' + this.$route.params.id + '/edit')
          .then(res => {
            this.selectedProperty = res.data.attribute.property;
            this.attribute = res.data.attribute;
            this.loading = false;
          })
      },

      getProperties() {
        axios.get('api/properties/lists')
          .then(res => {
            this.properties = res.data.properties;
          })
      },

      submit() {
        axios.put('api/attributes/' + this.$route.params.id, this.attribute)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/attributes');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },
    }
  }
</script>