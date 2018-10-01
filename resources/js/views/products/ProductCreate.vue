<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <h4>Novi proizvod</h4>

            <select-field
                    :options="brands"
                    label="Brend"
                    @input="product.brand_id = $event"
                    optionLabel="title"
                    trackBy="id"
                    :required=true
                    :error="error? error.brand_id : ''"
            ></select-field>

            <!-- Ovde treba da ide publish at -->

            <text-field
                    label="Naziv"
                    :required=true
                    v-model="product.title"
                    :error="error? error.title : ''"
            ></text-field>

            <text-field
                    label="Slug"
                    v-model="product.slug"
                    :error="error? error.slug : ''"
            ></text-field>

            <text-field
                    label="Šifra"
                    :required=true
                    v-model="product.code"
                    :error="error? error.code : ''"
            ></text-field>

            <text-area-field
                    label="Kratak opis"
                    v-model="product.short"
                    :error="error? error.short : ''"
            ></text-area-field>

            <!-- Ovde ide EDITOR komponenta -->

            <text-field
                    label="Cena"
                    v-model="product.price"
                    :error="error? error.price : ''"
            ></text-field>

            <text-field
                    label="Outlet cena"
                    v-model="product.price_outlet"
                    :error="error? error.price_outlet : ''"
            ></text-field>

            <select-multiple-field
                    :options="tags"
                    label="Tagovi"
                    @input="selectedTags = $event"
                    optionLabel="title"
                    trackBy="id"
            ></select-multiple-field>

            <checkbox-field
                    label="Publikovano"
                    v-model="product.publish"
            ></checkbox-field>

          </div>

          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="submit">Unesi</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        product: {
          slug: null,
        },
        brands: [],
        tags: [],
        selectedTags: [],
        error: null
      }
    },

    mounted() {
      this.getBrands();
      this.getTags();
    },

    methods: {
      getBrands() {
        axios.get('api/brands/lists')
          .then(res => {
            this.brands = res.data.brands;
          })
      },

      getTags() {
        axios.get('api/tags/lists')
          .then(res => {
            this.tags = res.data.tags;
          })
      },

      submit() {
        //
      }
    }
  }
</script>