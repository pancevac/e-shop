<template>

  <table class="table">
    <thead>
    <tr>
      <th scope="col">Proizvod</th>
      <th scope="col">Cena</th>
      <th scope="col">Akcija</th>
    </tr>
    </thead>
    <tbody>

    <tr v-for="(item, index) in items">
      <td>
        <div class="media">
          <div class="d-flex">
            <a :href="item.model.link">
              <img :src="item.model.cartProductImage" alt="">
            </a>
          </div>
          <div class="media-body">
            <p>{{ item.name }}</p>
          </div>
        </div>
      </td>
      <td>
        <h5>${{ item.price }}</h5>
      </td>
      <td>
        <a href="#" @click.prevent="removeItem(index)">
          <i class="lnr lnr-cross-circle"></i>
        </a>
      </td>
    </tr>

    </tbody>
  </table>

</template>

<script>
  export default {
    name: "WishListItems",

    props: ['wishListItems'],

    data() {
      return {
        items: [],
        domain: domain,
      }
    },

    created() {
      this.items = this.wishListItems;
    },

    methods: {

      /**
       * Remove item from wish-list
       */
      removeItem(index) {
        let item = this.items[index];

        axios.delete(this.domain + 'lista-zelja/' + item.rowId)
          .then(response => {
            // Delete item from items object
            this.removeFromObject(index);
            // Set toast message
            this.$toasted.global.toastDefault({ message: response.data.message });
          })
          .catch(e => {
            this.$toasted.global.toastError();
          })
      },

      /**
       * Remove item from object items...
       *
       * @param index
       */
      removeFromObject(index) {
        this.items = Object.keys(this.items).reduce((object, key) => {
          if (key !== index) {
            object[key] = this.items[key]
          }
          return object
        }, {});
      }

    },

  }
</script>