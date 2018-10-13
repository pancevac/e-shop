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
                v-if="! isLoading"
                :options="roles"
                label="Uloga"
                :value="user.role"
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

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4>Upload profilne slike</h4>

            <upload-image-helper
                :image="user.image"
                :defaultImage="null"
                :titleImage="'korisnika'"
                :error="error ? error.image : ''"
                @uploadImage="prepareImage($event)"
            ></upload-image-helper>

          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import UploadImageHelper from '../../components/helper/UploadImageHelper';

  export default {
    data() {
      return {
        user: {},
        roles: [],
        error: null,
        loading: true,
      }
    },

    components: {
      'upload-image-helper': UploadImageHelper
    },

    mounted(){
      this.getRoles();
      this.getUser();
    },

    computed: {
      isLoading() {
        return this.loading;
      }
    },

    methods: {

      getRoles() {
        axios
          .get('api/roles/lists')
          .then(res => {
            this.roles = res.data.roles;
          })
          .catch(e => {
            console.log(e)
          })
      },

      getUser() {
        axios.get('api/users/' + this.$route.params.id + '/edit')
          .then(res => {

            this.user = res.data.user;
            this.loading = false;
            if (res.data.user.block)
              this.user.block = true;
          })
      },

      submit() {
        axios.put('api/users/' + this.$route.params.id, this.user)
          .then(res => {
            this.uploadImage();
            this.$toasted.global.toastSuccess({ message: res.data.message });
            this.$router.push('/users');
          })
          .catch(e => {
            this.error = e.response.data.errors;
            this.$toasted.global.toastError({
              message: e.response.data.message
            });
          })
      },

      prepareImage(image) {
        this.user.image = image.src;
        this.formData = new FormData();
        this.formData.append('image', image.file);
        this.$toasted.global.toastSuccess({
          message: 'Slika je setovana.'
        });
      },

      uploadImage() {
        axios.post('api/users/' + this.user.id + '/uploadImage', this.formData)
          .then(res => {
            this.user.image = res.data.image;
            this.error = null
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