<template>
  <section class="product_description_area">
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Opis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Specifikacije</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Utisci</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
          {{ description }}
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="table-responsive">
            <table class="table">
              <tbody>
              <tr v-if="attributes" v-for="attribute in attributes">
                <td>
                  <h5>{{ attribute.property.title }}</h5>
                </td>
                <td>
                  <h5>{{ attribute.title }}</h5>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
          <div class="row">
            <div class="col-lg-6">
              <div class="row total_rate">
                <div class="col-6">
                  <div class="box_total">
                    <h5>Srednja ocena</h5>
                    <h4>{{ averageRate }}</h4>
                    <h6>({{ totalComments }} utisak(a))</h6>
                  </div>
                </div>
                <div class="col-6">
                  <div class="rating_list">
                    <h3>Based on 3 Reviews</h3>
                    <ul class="list">
                      <li>
                        <a href="#">5 Star
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i> 01</a>
                      </li>
                      <li>
                        <a href="#">4 Star
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i> 01</a>
                      </li>
                      <li>
                        <a href="#">3 Star
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i> 01</a>
                      </li>
                      <li>
                        <a href="#">2 Star
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i> 01</a>
                      </li>
                      <li>
                        <a href="#">1 Star
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i> 01</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="review_list">

                <div class="review_item" v-for="comment in comments">
                  <div class="media">
                    <div class="d-flex">

                    </div>
                    <div class="media-body">
                      <h4>{{ comment.commented.name }}</h4>
                      <star-rating
                          :star-size="starSize"
                          :rating="comment.rate"
                          :read-only="true"
                      ></star-rating>
                    </div>
                  </div>
                  <p>{{ comment.comment }}</p>
                </div>

              </div>
            </div>


            <div class="col-lg-6">
              <div class="review_box" v-if="!auth">
                <h4>Registrujte se kako bi mogli da ostavljate utiske</h4>
              </div>
              <div class="review_box" v-else="auth">
                <h4>Ostavite utisak</h4>
                <p>Vaša ocena:</p>

                <star-rating
                    :star-size="starSize"
                    v-model="review.rating"
                    @current-rating="setRatingFeedback"
                ></star-rating>

                <p>{{ ratingFeedback }}</p>

                <form class="row contact_form" id="review-form" novalidate="novalidate" @submit.prevent="submit">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input
                          v-model="review.name"
                          type="text"
                          class="form-control"
                          id="name"
                          name="name"
                          placeholder="Vaše ime">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <input
                          v-model="review.email"
                          type="email"
                          class="form-control"
                          id="email"
                          name="email"
                          placeholder="Email adresa">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <input
                          v-model="review.number"
                          type="text"
                          class="form-control"
                          id="number"
                          name="number"
                          placeholder="Broj mobilnog telefona">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea
                          v-model="review.message"
                          class="form-control"
                          name="message"
                          id="message"
                          rows="1"
                          placeholder="Utisak"
                      ></textarea>
                    </div>
                  </div>

                  <input type="hidden" name="rating" :value="review.rating"/>

                  <div class="col-md-12 text-right">
                    <button type="submit" value="submit" class="btn submit_btn">Pošalji</button>
                  </div>
                </form>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import StarRating from 'vue-star-rating';

  export default {
    name: "ProductDescription",

    props: ['comments', 'averageRate', 'totalComments', 'description', 'attributes', 'auth', 'action', 'toastMessage'],

    components: { StarRating },

    data() {
      return {
        review: {
          name: null,
          email: null,
          number: null,
          message: null,
          rating: null,
          productLink: this.action,
        },
        mouseOverStar: null,
        starSize: 20,
      }
    },

    mounted() {
      this.displayToastMessage();
    },

    methods: {
      submit() {
        if (this.auth) {
          axios.post(this.action, this.review)
            .then(response => {
              console.log(response);
              this.clearFormFields();
              location.reload();
            })
            .catch(e => {
              this.$toasted.global.toastError({
                message: e.response.data.message
              });
            })
        }
        //document.getElementById('review-form').submit();
      },
      setRatingFeedback(value) {
        this.mouseOverStar = value;
      },

      /**
       * Clear form inputs
       */
      clearFormFields() {
        let self = this;
        Object.keys(this.review).forEach(function (key, index) {
          self.review[key] = '';
        });
      },

      displayToastMessage() {
        if (this.toastMessage) {
          this.$toasted.global.toastDefault({ message: this.toastMessage });
        }
      }
    },

    computed: {
      ratingFeedback() {
        if (this.mouseOverStar === 1) {
          return 'loso'
        }
        if (this.mouseOverStar === 2) {
          return 'onako'
        }
        if (this.mouseOverStar === 3) {
          return 'oke'
        }
        if (this.mouseOverStar === 4) {
          return 'vrlo dobro'
        }
        if (this.mouseOverStar === 5) {
          return 'odlicno'
        }
      }
    }
  }
</script>

<style scoped>

</style>