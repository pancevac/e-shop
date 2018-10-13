<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Izmena uloge</h4>

            <text-field
                label="Naziv uloge"
                v-model="role.title"
                :error="error ? error.title : ''"
            ></text-field>

            <select-multiple-field
                :options="permissions"
                label="Dozvole"
                :value="role.permissions"
                @input="role.permissions_ids = $event"
                optionLabel="alias"
                trackBy="id"
            ></select-multiple-field>

            <checkbox-field
                label="Aktivna"
                v-model="role.active"
            ></checkbox-field>

          </div>

          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Izmena</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "RoleEdit",

    data() {
      return {
        role: {
          title: null,
          permissions_ids: null,
          active: null,
        },
        permissions: [],
        error: null,
      }
    },

    mounted() {
      this.getPermissions();
      this.getRole();
    },

    methods: {
      getPermissions() {
        axios
          .get('api/permissions/lists')
          .then(res => {
            this.permissions = res.data.permissions;
          })
          .catch(e => {
            swal({
              position: 'center',
              type: 'error',
              title: e.response.data.message,
            })
          })
      },

      getRole() {
        axios
          .get('api/roles/' + this.$route.params.id + '/edit')
          .then(res => {
            this.role = res.data.role;
          })
          .catch(e => {
            console.log(e)
          })
      },

      submit() {
        axios
          .put('/api/roles/' + this.$route.params.id, this.role)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/roles');
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