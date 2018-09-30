<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Novi atribut</h4>

            <select-field
                :options="properties"
                label="Osobina"
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
    name: "AttributeCreate",
    data() {
      return {
        attribute: {
          slug: null,
        },
        properties: [],
        error: null,
      }
    },

    mounted() {
      this.getProperties();
    },

    methods: {
      getProperties() {
        axios.get('api/properties/lists')
          .then(res => {
            this.properties = res.data.properties;
          })
      },

      submit() {
        axios.post('api/attributes', this.attribute)
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
      }
    }
  }
</script>