export default {
  namespaced: true,

  state: {
    /** auth **/
    user: null,
    admin: false,
  },

  getters: {
    /** auth **/
    getUser: state => {
      return state.user;
    },
    isAdmin: state => {
      return state.admin;
    }
  },

  mutations: {
    /** auth **/
    changeUser: (state, callback) => {
      state.user = callback;
      /*state.user.role.permissions.forEach(function (permission) {
        if (permission.title === 'admin.sudo')
          state.admin = true;
      });*/
      if (state.user.role_id === 1)
        state.admin = true;
    }
  },

  actions: {
    /** auth **/
    changeUser: (context, callback) => {
      context.commit('changeUser', callback);
    }
  }
}