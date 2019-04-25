<template>
  <div>
    <div class="cart-single-item" v-for="(item, index) in items">
      <div class="row align-items-center">
        <div class="col-md-5 col-12">
          <div class="product-item d-flex align-items-center">
            <a :href="item.model.link">
              <img :src="item.model.cartProductImage" class="img-fluid" alt="">
            </a>
            <h6>{{ item.name }}</h6>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="price">{{ item.price_formatted }}</div>
        </div>

        <div class="col-md-2 col-12">
          <a href="#" @click.prevent="removeItem(index)">
            <i class="lnr lnr-cross-circle"></i>
          </a>
        </div>
        <add-to-cart
          :product-url="item.model.link"
          :product-code="item.model.code"
          inline-template
        >
          <div class="col-md-3 col-12">
            <a @click.prevent="addToShoppingCart" class="genric-btn success circle arrow">Dodaj u korpu</a>
          </div>
        </add-to-cart>
      </div>
    </div>
  </div>
</template>

<script>
  import accounting from 'accounting';

  export default {

    name: "WishList",

    props: ['wishList'],

    data() {
      return {
        items: {}
      }
    },

    mounted() {
      this.items = this.wishList;
    },

    methods: {

      removeItem(index) {
        let item = this.items[index];

        axios.delete('/lista-zelja/' + item.rowId)
          .then(response => {

            // Set toast message
            this.$toasted.global.toastDefault({ message: response.data.message });

            // Update items
            this.items = response.data.wishListItems;
          })
          .catch(e => {
            this.$toasted.global.toastError();
          })
      },

    },

  }
</script>