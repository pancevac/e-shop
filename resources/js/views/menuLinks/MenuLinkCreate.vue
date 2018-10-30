<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje tipa menija</h4>

            <select-field
                :options="menuLinks"
                label="Nad link"
                @input="menuLink.parent = $event"
                optionLabel="title"
                trackBy="id"
                :error="error? error.parent : ''"
            ></select-field>

            <text-field
                label="Naziv linka"
                :required=true
                v-model="menuLink.title"
                :error="error? error.title : ''"
            ></text-field>

            <text-field
                label="Link"
                v-model="menuLink.link"
                :error="error? error.link : ''"
            ></text-field>

            <text-field
                label="Opis"
                v-model="menuLink.description"
                :error="error? error.description : ''"
            ></text-field>

            <text-field
                label="Redosled"
                v-model="menuLink.order"
                :error="error? error.order : ''"
            ></text-field>

            <checkbox-field
                label="Pripada šopu"
                v-model="menuLink.shop"
            ></checkbox-field>

            <checkbox-field
                label="Publikovano"
                v-model="menuLink.visible"
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
    name: "MenuLinkCreate",

    data() {
      return {
        menuLink: {
          title: null,
          link: null,
          description: null,
          order: null,
          parent: null,
          shop: false,
          visible: false,
          menu_id: this.$route.params.id,
        },
        menuLinks: [],
        error: null,
      }
    },

    mounted() {
      this.getMenuLinks();
    },

    methods: {

      getMenuLinks() {
        axios
          .get('api/menu-links/lists?menu_id=' + this.$route.params.id)
          .then(res => {
            this.menuLinks = res.data.menuLinks
          })
      },

      submit() {
        axios
          .post('api/menu-links', this.menuLink)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/menu-links/' + this.$route.params.id);
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
