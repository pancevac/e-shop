export default {
  namespaced: true,

  state: {
    // Count items in cart
    shoppingCartCount: null,
    // Count items in wish list
    wishListCount: null,
  },

  getters: {

    getShoppingCartCount: state => {
      return state.shoppingCartCount;
    },

    getWishListCount: state => {
      return state.wishListCount;
    },
  },

  mutations: {

    setShoppingCartCount: (state, callback) => {
      state.shoppingCartCount = callback;
    },
    setWishListCount: (state, callback) => {
      state.wishListCount = callback;
    },
  },

  actions: {

    changeShoppingCartCount: (context, callback) => {
      context.commit('setShoppingCartCount', callback);
    },
    changeWishListCount: (context, callback) => {
      context.commit('setWishListCount', callback);
    },
  }

}