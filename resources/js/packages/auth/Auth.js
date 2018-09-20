export default function (Vue) {
  Vue.auth = {
    setToken(token, expiration){
      localStorage.setItem('es_token', token);
      localStorage.setItem('es_expiration', expiration);
    },

    getToken(){
      var token = localStorage.getItem('es_token');
      var expiration = localStorage.getItem('es_expiration');

      if(!token || !expiration){
        return null;
      }

      if(Date.now() > parseInt(expiration)){
        this.destroyToken();
        return null;
      }else{
        return token;
      }
    },

    destroyToken(){
      localStorage.removeItem('es_token');
      localStorage.removeItem('es_expiration');
      localStorage.removeItem('vuex');
    },

    isAuth(){
      if (this.getToken())
        return true;
    }
  }

  Object.defineProperties(Vue.prototype, {
    $auth: {
      get: () => {
        return Vue.auth
      }
    }
  });
}