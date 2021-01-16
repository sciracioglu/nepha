<template>
  <div class="card">
    <div class="card-header">Yeni Ürün Tanımı</div>
    <div class="card-body">
    </div>
  </div>
</template>
<script>
    export default {
        data(){
          return {

          }
      },
      methods:{
          getProducts(){
              var self = this;
              axios.get('/products')
                  .then(({data})=>{
                      self.products = data;
                  });
          }
      }
    }
</script>
