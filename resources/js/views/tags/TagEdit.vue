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
        tag: {},
        error: null,
      }
    },

    mounted() {
      this.getTag();
    },

    methods: {
      getTag() {
        axios.get('api/tags/' + this.$route.params.id + '/edit')
          .then(res => {
            this.tag = res.data.tag;
          })
      },

      submit() {
        axios.put('api/tags/' + this.$route.params.id, this.tag)
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