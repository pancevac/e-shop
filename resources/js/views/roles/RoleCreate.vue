<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Kreiranje uloge</h4>

            <text-field
                label="Naziv uloge"
                v-model="role.title"
                :error="error ? error.title : ''"
            ></text-field>

            <select-multiple-field
                :options="permissions"
                label="Dozvole"
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
    name: "RoleCreate",

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

      submit() {
        axios
          .post('api/roles', this.role)
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