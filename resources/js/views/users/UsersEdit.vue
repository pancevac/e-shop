<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">

          <div class="card-body">
            <h4>Izmena korisnika</h4>

            <text-field
                label="Username"
                required=true
                v-model="user.name"
                :error="error? error.user : ''"
            ></text-field>
            <email-field
                label="Email"
                required=true
                v-model="user.email"
                :error="error? error.email : ''"
            ></email-field>
            <password-field
                label="Password"
                v-model="user.password"
                :error="error? error.password : ''"
            ></password-field>
            <password-field
                label="Potvrda passworda"
                v-model="user.password_confirmation"
                :error="error? error.password_confirmation : ''"
            ></password-field>
            <checkbox-field
                label="Block"
                v-model="user.block"
            ></checkbox-field>
            <select-field
                :options="options"
                label="Uloga"
                :value="role"
                @input="user.role_id = $event"
                optionLabel="title"
                trackBy="id"
                :error="error? error.role_id : ''"
            ></select-field>

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
        user: {},
        options: [
          {title: 'Admin', id: 1},
          {title: 'Moderator', id: 2},
          {title: 'Normal user', id: 3},
        ],
        error: null,
        role: {title: 'Moderator', id: 2}
      }
    },
    mounted(){
      this.getUser();
    },
    methods: {
      getUser() {
        axios.get('api/users/' + this.$route.params.id + '/edit')
          .then(res => {

            this.user = res.data.user;
            if (res.data.user.block)
              this.user.block = true;
          })
      },

      submit() {
        axios.put('api/users/' + this.$route.params.id, this.user)
          .then(res => {
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/users');
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