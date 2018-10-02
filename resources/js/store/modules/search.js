export default {
  namespaced: true,

  state: {

    /** search attribute **/
    searchAttribute: {
      text: '',
      option: 0,
      page: 1,
    },
  },

  getters: {

    /** search attribute **/
    getSearchAttribute: state => {
      return state.searchAttribute
    },

  },

  mutations: {

    /** search product **/
    changeSearchAttribute: (state, data) => {
      state.searchAttribute = data;
    },
    changeSearchAttributePage: (state, data) => {
      state.searchAttribute.page = data;
    },

  },

  actions: {

    /** search product **/
    changeSearchAttribute: (context, data) => {
      context.commit('changeSearchAttribute', data);
    },
    changeSearchAttributePage: (context, data) => {
      context.commit('changeSearchAttributePage', data);
    }
  }
}
