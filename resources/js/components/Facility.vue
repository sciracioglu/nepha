<template>
    <div>
      <div class="list-group">
        <div class="list-group-item list-group-item-primary">
          <div class="row">
            <div class="col-md-8">Tesis Adı</div>
            <div class="col-md-3">Menşei</div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <div class="list-group-item" v-for="(facility,index) in facilities" :key="index">
          <div class="row">
            <div class="col-md-8">{{ facility.facility }}</div>
            <div class="col-md-3">{{ facility.country.country }}</div>
            <div class="col-md-1 text-right">
                <a href="javascript:void(0);" @click="deleteFacility(facility.id)" class="btn btn-sm btn-danger btn-icon waves-effect waves-themed">
                  <i class="fal fa-trash"></i>
                </a>
            </div>
          </div>
        </div>
        <div class="list-group-item">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Tesis Adı</label>
                <input type="text" class="form-control" v-model='form.facility' />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Ülke</label>
                <v-select label="country" v-model="form.country" :options="countries"></v-select>
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
          facilities:[],
          countries:[],
          form:new Form({
            facility:null,
            country:{
              code2:'NL',
              code3:'NLD',
              country:'Netherlands (the)',
              id:528,
            }
          }),
        }
    },
    mounted(){
      this.getFacilities();
      this.getCountry();
    },
    methods:{
      getFacilities(){
        var self = this;
        axios.get('/facility-list')
          .then(({data})=>{
            self.facilities = data.facilities;
            self.countries = data.countries;
          })
      },
      getCountry(){
          var self = this;
          axios.get('/countries')
            .then(({data})=>{
                self.countries = data;
            });
      },
      save(){
        var self = this;
        let country = this.form.country;
        this.form.post('/facility')
          .then(function(){
            self.getFacilities();
            self.form.country = country;
          })
      },
      deleteFacility(gtin){
        var self = this;
        Swal.fire({
          title: 'Emin misniz?',
          text: "Tesis Silinecek!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Evet !',
          cancelButtonText: 'Hayır'
          }).then((result) => {
              if (result.isConfirmed) {
                  axios.delete('/facility/' + gtin)
                      .then(function(){
                          self.getFacilities();
                      });
              }
          });
      }
    }
}
</script>