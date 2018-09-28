<template>
  <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
    <div class="auth-box bg-dark border-top border-secondary">
      <div id="loginform">
        <div class="text-center p-t-20 p-b-20" style="padding-bottom: 20px;">
          <span class="db"><img src="../../assets/images/logo.png" alt="logo"/></span>
        </div>
        <!-- Form -->
        <form class="form-horizontal m-t-20" action="#" @submit.prevent="login">
          <div class="row p-b-30">
            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                </div>
                <input
                    type="text"
                    class="form-control form-control-lg"
                    placeholder="Username"
                    aria-label="Username"
                    aria-describedby="basic-addon1"
                    v-model="email"
                >
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-warning text-white" id="basic-addon2"><i
                      class="ti-pencil"></i></span>
                </div>
                <input
                    type="password"
                    class="form-control form-control-lg"
                    placeholder="Password"
                    aria-label="Password"
                    aria-describedby="basic-addon1"
                    v-model="password"
                >
              </div>
            </div>
          </div>
          <div class="row border-top border-secondary" style="padding-top: 20px">
            <div class="col-12">
              <div class="form-group">
                <div class="p-t-20">
                  <button class="btn btn-success float-right" type="submit">Login</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        email: null,
        password: null,
        error: null,
      }
    },
    methods: {
      login() {
        let data = {
          client_id: 2,
          client_secret: '3XIrIg0nWVrRHit18yrEozwvw0I88riBBh2r43BJ',
          grant_type: 'password',
          username: this.email,
          password: this.password
        };

        axios.post('oauth/token', data)
          .then(res => {
            this.$auth.setToken(res.data.access_token, res.data.expires_in + Date.now());
            this.$router.push('/home');
            location.reload();
          })
          .catch(e => {
            this.error = e.response.data;
          })
      }
    }
  }
</script>

<style scoped>

</style>