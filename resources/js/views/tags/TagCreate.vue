<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Novi tag</h4>

            <text-field
                    label="Naziv"
                    :required=true
                    v-model="tag.title"
                    :error="error? error.title : ''"
            ></text-field>

            <text-field
                    label="Slug"
                    v-model="tag.slug"
                    :error="error? error.slug : ''"
            ></text-field>

            <checkbox-field
                    label="Publikovano"
                    v-model="tag.publish"
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
    data() {
      return {
        tag: {
          slug: null,
        },
        error: null,
      }
    },

    methods: {
      submit() {
        axios.post('api/tags', this.tag)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/tags');
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