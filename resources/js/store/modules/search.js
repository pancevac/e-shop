export default {
  namespaced: true,

  state: {

    /** search attribute **/
    searchAttribute: {
      text: '',
      option: 0,
      page: 1,
    },

    /** search product **/
    searchProduct: {
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

    /* search product */
    getSearchProduct: state => {
      return state.searchProduct;
    },

  },

  mutations: {

    /** search attribute **/
    changeSearchAttribute: (state, data) => {
      state.searchAttribute = data;
    },
    changeSearchAttributePage: (state, data) => {
      state.searchAttribute.page = data;
    },

    /* search product */
    changeSearchProduct: (state, data) => {
      state.searchProduct = data;
    },
    changeSearchProductPage: (state, data) => {
      state.searchProduct.page = data;
    }

  },

  actions: {

    /** search attribute **/
    changeSearchAttribute: (context, data) => {
      context.commit('changeSearchAttribute', data);
    },
    changeSearchAttributePage: (context, data) => {
      context.commit('changeSearchAttributePage', data);
    },

    /* search product */
    changeSearchProduct: (context, data) => {
      context.commit('changeSearchProduct', data);
    },
    changeSearchProductPage: (context, data) => {
      context.commit('changeSearchProductPage', data);
    },
  }
}
