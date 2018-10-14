<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Izmena tipa menija</h4>

            <text-field
                label="Naziv tipa menija"
                :required=true
                v-model="menu.title"
                :error="error? error.title : ''"
            ></text-field>

            <text-field
                label="Slug"
                v-model="menu.slug"
                :error="error? error.slug : ''"
            ></text-field>

            <checkbox-field
                label="Publikovano"
                v-model="menu.visible"
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
    name: "MenuEdit",

    data() {
      return {
        menu: {
          title: null,
          slug: null,
          visible: false,
        },
        error: null,
      }
    },

    mounted() {
      this.getMenu();
    },

    methods: {
      getMenu() {
        axios.get('api/menus/' + this.$route.params.id + '/edit')
          .then(res => {
            this.menu = res.data.menu;
          })
      },

      submit() {
        axios
          .post('api/menus', this.menu)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/menus');
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