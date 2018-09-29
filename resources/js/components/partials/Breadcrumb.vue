<template>
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">{{ pageTitle }}</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <router-link
                    v-if="breadcrumbList"
                    :to="'/home'"
                    href="#"
                >
                  Početna
                </router-link>
              </li>
              <li
                  class="breadcrumb-item"
                  v-for="(breadcrumb, index) in breadcrumbList"
                  :key="index"
                  @click="routeTo(index)"
                  :class="{ 'active': !breadcrumb.link }"
              >
                <a v-if="breadcrumb.link" href="#">{{ breadcrumb.title }}</a>
                <slot v-if="!breadcrumb.link">{{ breadcrumb.title }}</slot>
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Breadcrumb",
    data() {
      return {
        breadcrumbList: [],
        pageTitle: null,
      }
    },

    mounted() {
      this.updateList();
      this.updateTitle();
    },

    watch: {
      '$route'() {
        this.updateList();
      }
    },

    methods: {
      updateList() {
        this.breadcrumbList = this.$route.meta.breadcrumb;
      },
      updateTitle() {
        this.pageTitle = this.$route.meta.pageTitle;
      },
      routeTo(index) {
        if (this.breadcrumbList[index]) {
          this.$router.push(this.breadcrumbList[index].link);
        }
      }
    }
  }
</script>