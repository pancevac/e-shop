<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje dozvole</h4>

            <select-field
                v-if="models"
                :options="models"
                label="Izaberite model dozvole"
                v-model="permission.model"
                optionLabel="className"
                trackBy="className"
                :required="true"
            ></select-field>

            <select-field
                v-if="abilities"
                :options="abilities"
                label="Izaberite metod modela"
                v-model="permission.ability"
                :required="true"
            ></select-field>

            <text-field
                label="Naziv dozvole (Alias)"
                v-model="permission.alias"
                :error="error ? error.alias : ''"
            ></text-field>

            <checkbox-field
                label="Aktivna"
                v-model="permission.active"
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
    name: "PermissionCreate",

    data() {
      return {
        permission: {
          alias: null,
          model: null,
          ability: null,
        },
        models: [],
        abilities: [],
        error: null,
      }
    },

    mounted() {
      this.getModels();
      this.getAbilities();
    },

    methods: {

      getModels() {
        axios.get('api/permissions/models')
          .then(res => {
            this.models = res.data.models;
          })
          .catch(e => {
            this.$toasted.global.toastError({ message: e.response.data.message })
          })
      },

      getAbilities() {
        axios.get('api/permissions/abilities')
          .then(res => {
            this.abilities = res.data.abilities;
          })
          .catch(e => {
            this.$toasted.global.toastError({ message: e.response.data.message })
          })
      },

      submit() {
        axios
          .post('api/permissions', this.permission)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/permissions');
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