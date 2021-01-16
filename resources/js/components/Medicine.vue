<template>
    <div>
      <div class="list-group">
        <div class="list-group-item list-group-item-primary">
          <div class="row">
            <div class="col-md-4">Barkod</div>
            <div class="col-md-7">Ürün Adı</div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <div class="list-group-item" v-for="(medicine,index) in medicines" :key="index">
          <div class="row">
            <div class="col-md-4">{{ medicine.gtin }}</div>
            <div class="col-md-7">{{ medicine.medicine }}</div>
            <div class="col-md-1 text-right">
                <a href="javascript:void(0);" @click="deleteMedicine(medicine.gtin)" class="btn btn-sm btn-danger btn-icon waves-effect waves-themed">
                  <i class="fal fa-trash"></i>
                </a>
            </div>
          </div>
        </div>
        <div class="list-group-item">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Barkod</label>
                <input type="text" class="form-control" v-model='form.gtin' />
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label>Ürün</label>
                <input type="text" class="form-control" v-model='form.medicine' />
              </div>
            </div>
            <div class="col-md-1 text-right">
              <div class="form-group">
                <label style="display:block">&nbsp;</label>
                <a href="javascript:void(0);" @click="save()" class="btn btn-primary btn-icon waves-effect waves-themed">
                  <i class="fal fa-save"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
export default{
    data(){
        return {
          medicines:[],
          form:new Form({
            gtin:null,
            medicine:null,
          }),
        }
    },
    mounted(){
      this.getMedicines();
    },
    methods:{
      getMedicines(){
        var self = this;
        axios.get('/medicine-list')
          .then(({data})=>{
            self.medicines = data;
          })
      },
      save(){
        var self = this;
        this.form.post('/medicine')
          .then(function(){
            self.getMedicines();
          })
      },
      deleteMedicine(gtin){
        var self = this;
        Swal.fire({
          title: 'Emin misniz?',
          text: "Ürün Silinecek!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Evet !',
          cancelButtonText: 'Hayır'
          }).then((result) => {
              if (result.isConfirmed) {
                  axios.delete('/medicine/' + gtin)
                      .then(function(){
                          self.getMedicines();
                      });
              }
          });
      }
    }
}
</script>