<template>
    <div>
      <div class="list-group">
        <div class="list-group-item list-group-item-primary">
          <div class="row">
            <div class="col-md-3">Barkod</div>
            <div class="col-md-5">Ürün Adı</div>
            <div class="col-md-3">Grup</div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <div class="list-group-item" v-for="(medicine,index) in medicines" :key="index">
          <div class="row">
            <div class="col-md-3">{{ medicine.barcode }}</div>
            <div class="col-md-5">{{ medicine.medicine }}</div>
            <div class="col-md-3">{{ groups[medicine.group] }}</div>
            <div class="col-md-1 text-right">
                <a href="javascript:void(0);" @click="deleteMedicine(medicine.barcode)" class="btn btn-sm btn-danger btn-icon waves-effect waves-themed">
                  <i class="fal fa-trash"></i>
                </a>
            </div>
          </div>
        </div>
        <div class="list-group-item">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Barkod</label>
                <input type="text" class="form-control" v-model='form.gtin' />
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label>Ürün</label>
                <input type="text" class="form-control" v-model='form.medicine' />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Grubu</label>
                <select type="text" class="form-control" v-model='form.group'>
                  <option value="" selected>Seçin</option>
                  <option value="soguk_kit">Soğuk Kit</option>
                  <option value="radyofarmasotik">Radyofarmasötikler</option>
                </select>
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
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';
export default{
    data(){
        return {
          medicines:[],
          groups:{
                'soguk_kit':'Soguk Kit',
                'radyofarmasotik':'Radyofarmasötikler',
            },
          form:new Form({
            gtin:null,
            medicine:null,
            group:null,
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
            self.medicines = data.medicines;
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