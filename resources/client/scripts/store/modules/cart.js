export default {
  namespaced: true,

  state: {

    cartItems: null,
    itemCount: null,
    subTotalPrice: null,
    totalPrice: null,
    discountPrice: null,
    coupon: null,

  },

  getters: {

    getCartItems: state => {
      return state.cartItems;
    },

    getItemCount: state => {
      return state.itemCount;
    },

    getSubTotalPrice: state => {
      return state.subTotalPrice;
    },

    getTotalPrice: state => {
      return state.totalPrice;
    },

    getDiscountPrice: state => {
      return state.subTotalPrice - state.totalPrice;
    },

    getCoupon: state => {
      return state.coupon;
    },

  },

  mutations: {

    setCartItems: (state, callback) => {
      state.cartItems = callback;
    },

    setItemCount: (state, callback) => {
      state.itemCount = callback;
    },

    setSubTotalPrice: (state, callback) => {
      state.subTotalPrice = callback;
    },

    setTotalPrice: (state, callback) => {
      state.totalPrice = callback;
    },

    setCoupon: (state, callback) => {
      state.coupon = callback;
    },
  },

  actions: {

    changeCartItems: (context, callback) => {
      context.commit('setCartItems', callback);
    },

    changeItemCount: (context, callback) => {
      context.commit('setItemCount', callback);
    },

    changeSubTotalPrice: (context, callback) => {
      context.commit('setSubTotalPrice', callback);
    },

    changeTotalPrice: (context, callback) => {
      context.commit('setTotalPrice', callback);
    },

    changeCoupon: (context, callback) => {
      context.commit('setCoupon', callback);
    },
  }

}