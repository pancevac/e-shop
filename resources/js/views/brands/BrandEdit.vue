<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje Brenda</h4>

            <text-field
                label="Naziv"
                :required=true
                v-model="brand.title"
                :error="error? error.title : ''"
            ></text-field>

            <text-field
                label="Slug (Friendly URL)"
                v-model="brand.slug"
                :error="error? error.slug : ''"
            ></text-field>

            <text-field
                label="Redosled"
                v-model="brand.order"
                :error="error? error.order : ''"
            ></text-field>

            <checkbox-field
                label="Publikovano"
                v-model="brand.publish"
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
    data() {
      return {
        brand: {},
        error: null,
      }
    },

    mounted() {
      this.getBrand();
    },

    methods: {
      getBrand() {
        axios.get('api/brands/' + this.$route.params.id + '/edit')
          .then(res => {
            this.brand = res.data.brand;
            console.log(this.brand);
          })
          .catch(e => {
            console.log(e);
          })
      },

      submit() {
        axios.put('api/brands/' + this.$route.params.id, this.brand)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/brands');
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

<style scoped>

</style>