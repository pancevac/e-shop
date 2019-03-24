export default {
  namespaced:true,

  state: {

    wishListItems: null,

    itemCount: null,

  },

  getters: {

    getWishListItems: state => {
      return state.wishListItems;
    },

    getItemCount: state => {
      return state.item;
    },

  },

  mutations: {

    setWishListItems: (state, callback) => {
      state.wishListItems = callback;
    },

    setItemCOunt: (state, callback) => {
      state.itemCount = callback;
    }

  },

  actions: {

    changeWishListItems: (context, callback) => {
      context.commit('setWishListItems', callback);
    },

    changeItemCount: (context, callback) => {
      context.commit('setItemCOunt', callback);
    },

  }
}