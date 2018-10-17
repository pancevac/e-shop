<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje tipa menija</h4>

            <select-field
                v-if="!isLoading"
                :options="menuLinks"
                label="Nad link"
                :value="selectedParentLink"
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
    name: "MenuLinkEdit",

    data() {
      return {
        menuLink: {
          title: null,
          link: null,
          description: null,
          order: null,
          parent: null,
          visible: false,
          menu_id: null,
        },
        menuLinks: [],
        error: null,
        selectedParentLink: null,
        loading: true,
      }
    },

    computed: {
      isLoading() {
        return this.loading;
      }
    },

    mounted() {
      this.getMenuLink();
      this.getMenuLinks();
    },

    methods: {

      getMenuLink() {
        axios
          .get('api/menu-links/' + this.$route.params.id + '/edit')
          .then(res => {
            this.selectedParentLink = res.data.menuLink.parent;
            this.menuLink = res.data.menuLink;
            this.getMenuLinks();
          })
      },

      getMenuLinks() {
        axios
          .get('api/menu-links/lists?menu_id=' + this.menuLink.menu_id + '&except=' + this.$route.params.id)
          .then(res => {
            this.menuLinks = res.data.menuLinks;
            this.loading = false;
          })
      },

      submit() {
        axios
          .put('api/menu-links/' + this.$route.params.id, this.menuLink)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/menu-links/' + this.menuLink.menu_id);
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