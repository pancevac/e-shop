<template>
  <div class="review-wrapper">
    <div class="row">
      <div class="col-lg-6">
        <div class="review-stat d-flex align-items-center flex-wrap">
          <div class="review-overall">
            <h3>Overall</h3>
            <div class="main-review">4.0</div>
            <span>(03 Reviews)</span>
          </div>
          <div class="review-count">
            <h4>Based on 3 Reviews</h4>
            <div class="single-review-count d-flex align-items-center">
              <span>5 Star</span>
              <div class="total-star five-star d-flex align-items-center">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
              </div>
              <span>01</span>
            </div>
            <div class="single-review-count d-flex align-items-center">
              <span>4 Star</span>
              <div class="total-star four-star d-flex align-items-center">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
              </div>
              <span>01</span>
            </div>
            <div class="single-review-count d-flex align-items-center">
              <span>3 Star</span>
              <div class="total-star three-star d-flex align-items-center">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
              </div>
              <span>01</span>
            </div>
            <div class="single-review-count d-flex align-items-center">
              <span>2 Star</span>
              <div class="total-star two-star d-flex align-items-center">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
              </div>
              <span>00</span>
            </div>
            <div class="single-review-count d-flex align-items-center">
              <span>1 Star</span>
              <div class="total-star one-star d-flex align-items-center">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
              </div>
              <span>00</span>
            </div>
          </div>
        </div>
        <div class="total-comment">

          <div class="single-comment" v-for="comment in comments">
            <div class="user-details d-flex align-items-center">
              <img src="img/organic-food/u1.png" class="img-fluid" alt="">
              <div class="user-name">
                <h5>{{ comment.commented.name }}</h5>

                <star-rating
                        :star-size="starSize"
                        :rating="comment.rate"
                        :read-only="true"
                ></star-rating>

                <!--<div class="total-star five-star d-flex align-items-center">-->
                  <!--<i class="fa fa-star" aria-hidden="true"></i>-->
                  <!--<i class="fa fa-star" aria-hidden="true"></i>-->
                  <!--<i class="fa fa-star" aria-hidden="true"></i>-->
                  <!--<i class="fa fa-star" aria-hidden="true"></i>-->
                  <!--<i class="fa fa-star" aria-hidden="true"></i>-->
                <!--</div>-->
              </div>
            </div>
            <p class="user-comment">{{ comment.comment }}</p>
          </div>

        </div>
      </div>

      <div class="col-lg-6">
        <div class="add-review" v-if="!auth">
          <h3>Registrujte se kako bi mogli da ostavljate utiske</h3>
        </div>
        <div class="add-review" v-else="auth">
          <h3>Ostavite utisak</h3>
          <div class="single-review-count mb-15 d-flex align-items-center">
            <span>Vaša ocena:</span>

            <star-rating
                    :star-size="starSize"
                    v-model="review.rating"
                    @current-rating="setRatingFeedback"
            ></star-rating>

            <p>{{ ratingFeedback }}</p>

            <!--<div class="total-star five-star d-flex align-items-center">
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
            </div>
            <span>Outstanding</span>-->
          </div>
          <form class="main-form" @submit.prevent="submit">

            <input
                v-model="review.name"
                type="text"
                placeholder="Vaše ime"
                onfocus="this.placeholder=''"
                onblur="this.placeholder = 'Vaše puno ime'"
                id="name"
                name="name"
                class="common-input"
                required
            >
            <input
                v-model="review.name"
                type="email"
                pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$"
                placeholder="Email adresa"
                onfocus="this.placeholder=''"
                onblur="this.placeholder = 'Email adresa'"
                id="email"
                name="email"
                class="common-input"
                required
            >
            <input
                v-model="review.number"
                type="text"
                placeholder="Broj telefona"
                onfocus="this.placeholder=''"
                onblur="this.placeholder = 'Broj telefona'"
                id="number"
                name="number"
                class="common-input"
                required
            >
            <textarea
                v-model="review.message"
                placeholder="Utisak"
                onfocus="this.placeholder=''"
                onblur="this.placeholder = 'Utisak'"
                id="message"
                name="message"
                class="common-textarea"
                required
            ></textarea>

            <input type="hidden" name="rating" :value="review.rating"/>

            <button class="view-btn color-2"><span>Pošalji</span></button>

          </form>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import StarRating from 'vue-star-rating';

  export default {
    name: "comments",

    components: { StarRating },

    props: ['comments', 'averageRate', 'totalComments', 'auth', 'action', 'toastMessage'],

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
      },

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
      },

    },

  }
</script>