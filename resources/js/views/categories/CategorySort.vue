<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">

            <div>
              <tree :data="data" draggable="draggable"  :indent="30">
                <div slot-scope="{data, level, store}">
                  <template v-if="!data.isDragPlaceHolder">
                    <b v-if="data.children &amp;&amp; data.children.length" @click="store.toggleOpen(data)">{{data.open ? '-' : '+'}}&nbsp;</b>
                    <span>{{data.title}}</span>
                  </template>
                </div>
              </tree>
            </div>

          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="button" class="btn btn-primary" @click="save">Sačuvaj</button>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</template>

<script>
  import { DraggableTree } from 'vue-draggable-nested-tree'

  export default {
    data() {
      return {
        categories: {},
        data: [],
      }
    },

    components: {
      'tree': DraggableTree
    },

    mounted() {
      this.getCategories();
    },

    methods: {
      getCategories() {
        axios.get('api/categories/sort')
          .then(res => {
            this.data = res.data.categories;
          })
      },

      order(items){
        return items.map((item) => {
          if (item.children.length) {
            return {
              id: item.id,
              title: item.title,
              children: this.order(item.children),
            };
          }

          return {
            id: item.id,
            title: item.title,
          };
        });
      },

      save() {
        let data = this.order(this.data);
        axios.post('api/categories/order', {'categories': data})
          .then(res => {
            this.data = res.data.categories;
            this.$toasted.global.toastSuccess({ message: res.data.message });
          })
      }
    }
  }
</script>

<style>
  .he-tree{
    border: 1px solid #ccc;
    padding: 20px;
    width: 300px;
  }
  .tree-node{
  }
  .tree-node-inner{
    padding: 5px;
    border: 1px solid #ccc;
    cursor: pointer;
  }
  .draggable-placeholder{
  }
  .draggable-placeholder-inner{
    border: 1px dashed #0088F8;
    box-sizing: border-box;
    background: rgba(0, 136, 249, 0.09);
    color: #0088f9;
    text-align: center;
    padding: 0;
    display: flex;
    align-items: center;
  }
</style>