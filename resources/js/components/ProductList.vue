<template>
    <div v-cloak>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel" v-if='products.length > 0 && new_form === 0 && selected === 0'>
                    <div class="panel-hdr">
                        <h2>Tanımlı Ürünler</h2>
                        <div class="panel-toolbar">
                            <button type="button" @click="new_form=1" class="btn btn-icon btn-sm btn-secondary mr-1 shadow-0 waves-effect waves-themed">
                                <i class="fal fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="form-group">
                                <label class="form-label"></label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fal fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" v-model="search" class="form-control border-left-0 bg-transparent pl-0" placeholder="Arayın...">
                                </div>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead class="thead-themed">
                                    <tr>
                                        <th>GTIN</th>
                                        <th>Parti No</th>
                                        <th>Üretim Tesisi</th>
                                        <th>Yüklenen Aktivite</th>
                                        <th>Birimi</th>
                                        <th>Hedeflenen Aktivite</th>
                                        <th>Hedef Birimi</th>
                                        <th>Yükleme Tarihi</th>
                                        <th>DT</th>
                                        <th>Ülke Kodu</th>
                                        <th>Son Kullanım Tarihi</th>
                                        <th>Teslim Tarihi</th>
                                        <th>Onay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for='(product,index) in filtre' :key="index">
                                        <td>
                                            <a href="#" @click="detail(product)">
                                                {{ product.gtin }}
                                            </a>
                                        </td>
                                        <td>{{ product.bn }}</td>
                                        <td>{{ product.production_identifier }}</td>
                                        <td>{{ product.loaded_activity }}</td>
                                        <td>{{ product.loaded_unit_id }}</td>
                                        <td>{{ product.calibration_activity }}</td>
                                        <td>{{ product.calibration_unit_id }}</td>
                                        <td>{{ product.load_date }}</td>
                                        <td>{{ product.dt }}</td>
                                        <td>{{ product.country_code }}</td>
                                        <td>{{ product.xd }}</td>
                                        <td>{{ product.delivery }}</td>
                                        <td>{{ product.uc }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel" v-if='products.length === 0 || new_form && selected === 0' v-cloak>
                    <div class="panel-hdr">
                        <h2>İTS'ye Bildir</h2>
                        <div class="panel-toolbar" v-if='products.length > 0'>
                            <button type="button" @click="new_form = 0" data-action="panel-close" class="btn btn-sm btn-danger mr-2 btn-icon waves-effect waves-themed">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <form
                                @submit.prevent="saveProduct"
                                @change="form.errors.clear()"
                                >
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Kurum Tipi</label>
                                            <select v-model='form.stakeholderType' class="form-control" @change="getCorp()">
                                                <option value="hastane">Hastane</option>
                                                <option value="uretici">Üretici</option>
                                                <option value="ihracatci">İhracatçı</option>
                                                <option value="geriodemekurumu">Geri Ödeme Kurumu</option>
                                            </select>
                                            <span class="text-danger" v-if="form.errors.has('stakeholderType')">Kurum Tipi zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>İl</label>
                                            <v-select label="city" v-model="form.cityPlate" :options="cities"></v-select>
                                            <span class="text-danger" v-if="form.errors.has('cityPlate')">İl zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class='form-label'>Kurum</label>
                                            <span v-if="loading"><i class="fal fa-cog fa-2x fa-spin"></i></span>
                                            <v-select v-else label="companyName" v-model="form.togln" :options="corps"></v-select>
                                            <span class="text-danger" v-if="form.errors.has('togln')">TOGLN Zorunlu alan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Ürün</label>
                                            <select v-model='form.gtin' class="form-control">
                                                <optgroup v-for='group in groups' :label="group.name">
                                                    <option v-for="option in medicines" :value="option.barcode" v-if='group.group === option.group'>
                                                        {{ option.medicine }}
                                                    </option>
                                                </optgroup>
                                            </select>
                                            <span class="text-danger" v-if="form.errors.has('gtin')">GTIN Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Parti No</label>
                                            <input type="text" v-model="form.bn" class="form-control" />
                                            <span class="text-danger" v-if="form.errors.has('bn')">BN Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Üretim Tesisi</label>
                                            <select class="form-control" v-model='form.production_identifier' @change="setCountry($event)">
                                                <option v-for='facility in facilities' :value='facility.facility'>{{ facility.facility }}</option>
                                            </select>
                                            <input type="text" v-model="form.production_identifier" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Teslim Tarihi</label>
                                            <datetime v-model="form.delivery" type="datetime" :minute-step="30" input-class="form-control" format="dd/MM/yyyy HH:mm" :auto='true' :phrases="{ok: 'Tamam', cancel: 'iptal'}" zone="Europe/Istanbul"></datetime>
                                            <span class="text-danger" v-if="form.errors.has('delivery')">Teslim Tarihi Zorunlu alan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label class='form-label'>Yüklenen Aktivite</label>
                                            <input type="text" v-model="form.loaded_activity" class="form-control" />
                                            <span class="text-danger" v-if="form.errors.has('loaded_activity')">Yüklenen Aktivite Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Yüklenen Aktivite Birimi</label>
                                            <select v-model="form.loaded_unit_id" class="form-control">
                                                <option>Seçin</option>
                                                <option value="1">&#181;ci</option>
                                                <option value="2">mci</option>
                                                <option value="3">mbq</option>
                                                <option value="4">gbq</option>
                                                <option value="5">kutu/vial</option>
                                            </select>
                                            <span class="text-danger" v-if="form.errors.has('loaded_unit_id')">Yüklenen Aktivite Birimi Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Hedeflenen Aktivite</label>
                                            <input type="text" v-model="form.calibration_activity" class="form-control" />
                                            <span class="text-danger" v-if="form.errors.has('calibration_activity')">Hedeflenen Aktivite Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <label class='form-label'>Hedeflenen Aktivite Birimi</label>
                                            <select v-model="form.calibration_unit_id" class="form-control">
                                                <option>Seçin</option>
                                                <option value="1">&#181;ci</option>
                                                <option value="2">mci</option>
                                                <option value="3">mbq</option>
                                                <option value="4">gbq</option>
                                                <option value="5">kutu/vial</option>
                                            </select>
                                            <span class="text-danger" v-if="form.errors.has('calibration_unit_id')">Hedeflenen Aktivite Birimi Zorunlu alan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Yükleme Tarihi</label>
                                            <datetime v-model="form.load_date" type="date" input-class="form-control" format="dd/MM/yyyy" :auto='true' :phrases="{ok: 'Tamam', cancel: 'iptal'}" zone="Europe/Istanbul"></datetime>
                                            <span class="text-danger" v-if="form.errors.has('load_date')">Yükleme Tarihi Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>DT</label>
                                            <select v-model="form.dt" class="form-control">
                                                <option>Seçin</option>
                                                <option value="M">Yurt İçi</option>
                                                <option value="I">İthalat</option>
                                                <option value="E">İhracat</option>
                                            </select>
                                            <span class="text-danger" v-if="form.errors.has('dt')">DT Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Ülke</label>
                                            <v-select label="country" v-model="form.country_code" :options="countries"></v-select>
                                            <span class="text-danger" v-if="form.errors.has('country_code')">Ülke Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Son Kullanma Tarihi</label>
                                            <datetime v-model="form.xd" type="datetime" :minute-step="30" input-class="form-control" format="dd/MM/yyyy HH:mm" :auto='true' :phrases="{ok: 'Tamam', cancel: 'iptal'}" zone="Europe/Istanbul"></datetime>
                                            <span class="text-danger" v-if="form.errors.has('xd')">Son Kullanma Tarihi Zorunlu alan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6" style="text-align:right;">
                                        <button type="submit" class="btn btn-primary btn-lg btn-icon rounded-circle hover-effect-dot waves-effect waves-themed">
                                            <i class="fal fa-save"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel" v-if='selected && new_form === 0' v-cloak>
                    <div class="panel-hdr">
                        <h2>Ürün Detayı</h2>
                        <div class="panel-toolbar">
                            <button type="button" @click="selected = 0; selected_product = [];" data-action="panel-close" class="btn btn-sm btn-danger mr-2 btn-icon waves-effect waves-themed">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width:30%">GTIN</th>
                                        <td>: {{ selected_product.gtin }}</td>
                                    </tr>
                                    <tr>
                                        <th>Parti No</th>
                                        <td>: {{ selected_product.bn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Üretim Tesisi</th>
                                        <td>: {{ selected_product.production_identifier }}</td>
                                    </tr>
                                    <tr>
                                        <th>Yüklenen Aktivite</th>
                                        <td>: {{ selected_product.loaded_activity }}</td>
                                    </tr>
                                    <tr>
                                        <th>Birimi</th>
                                        <td>: {{ selected_product.loaded_unit_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hedeflenen Aktivite</th>
                                        <td>: {{ selected_product.calibration_activity }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hedef Birimi</th>
                                        <td>: {{ selected_product.calibration_unit_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Yükleme Tarihi</th>
                                        <td>: {{ selected_product.load_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>DT</th>
                                        <td>: {{ selected_product.dt }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ülke Kodu</th>
                                        <td>: {{ selected_product.country_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Son Kullanım Tarihi</th>
                                        <td>: {{ selected_product.xd }}</td>
                                    </tr>
                                    <tr>
                                        <th>Onay</th>
                                        <td>: {{ selected_product.uc }}</td>
                                    </tr>
                                </tbody>
                            </table>
                           <div class="row">
                                <div class="col-md-6"></div>
                                    <div class="col-md-6" style="text-align: right;">
                                    <button type="button" @click='cancel()' class="btn btn-danger btn-lg btn-icon rounded-circle hover-effect-dot waves-effect waves-themed">
                                        <i class="fal fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
    export default {
        components: {
            Datetime
        },
        mounted() {
            this.getProducts();
            this.getCity();
            this.getCountry();
            this.getCorp();
            this.getMedicines();
            this.getFacilities();
        },
        data(){
          return {
            loading:0,
            new_product:0,
            new_form:0,
            search:'',
            products:[],
            selected:0,
            selected_product:[],
            cities:[],
            corps:[],
            countries:[],
            medicines:[],
            groups:[],
            facilities:[],
            form:new Form({
                stakeholderType:'hastane',
                getAll:false,
                cityPlate:{
                    city:"Ankara",
                    code:"06",
                    id:6,
                },
                togln:null,
                gtin:null,
                bn:null,
                delivery:null,
                production_identifier:null,
                loaded_activity:null,
                loaded_unit_id:null,
                calibration_activity:null,
                calibration_unit_id:null,
                load_date:null,
                dt:"I",
                country_code:{
                    code2:'NL',
                    code3:'NLD',
                    country:'Netherlands (the)',
                    id:528,
                },
                xd:null,
            }),
          }
      },
      computed:{
        filtre:function() {
            return this.products.filter(product => {
                var letters = { "İ": "i", "I": "ı", "Ş": "ş", "Ğ": "ğ", "Ü": "ü", "Ö": "ö", "Ç": "ç" };
                var gtin =  product.gtin != null ? product.gtin.replace(/(([İIŞĞÜÇÖ]))/g, function(letter){ return letters[letter]; }) : ''
                var bn = product.bn != null ? product.bn.replace(/(([İIŞĞÜÇÖ]))/g, function(letter){ return letters[letter]; }) : ''
                var production_identifier = product.production_identifier != null ? product.production_identifier.replace(/(([İIŞĞÜÇÖ]))/g, function(letter){ return letters[letter]; }) : ''
                var load_date = product.load_date != null ? product.load_date.replace(/(([İIŞĞÜÇÖ]))/g, function(letter){ return letters[letter]; }) : ''
                var delivery = product.delivery != null ? product.delivery.replace(/(([İIŞĞÜÇÖ]))/g, function(letter){ return letters[letter]; }) : ''
                var xd = product.xd != null ? product.xd.replace(/(([İIŞĞÜÇÖ]))/g, function(letter){ return letters[letter]; }) : ''
                var search = this.search.replace(/(([İIŞĞÜÇÖ]))/g, function(letter){ return letters[letter]; })

                return gtin.toLowerCase().indexOf(search.toLowerCase()) > -1 ||
                        (bn.toLowerCase().indexOf(search.toLowerCase()) > -1 && bn != null) ||
                        (production_identifier.toLowerCase().indexOf(search.toLowerCase()) > -1 && production_identifier != null) ||
                        (load_date.toLowerCase().indexOf(search.toLowerCase()) > -1 && load_date != null) ||
                        (delivery.toLowerCase().indexOf(search.toLowerCase()) > -1 && delivery != null) ||
                        (xd.toLowerCase().indexOf(search.toLowerCase()) > -1 && xd != null)
            })
        },
      },
      methods:{
          setCountry(event){
              this.form.country_code = this.facilities[event.target.selectedIndex].country;
          },
          getCorp(){
            var self = this;
            if(this.form.cityPlate !== '' && this.form.stakeholderType !== ''){
                this.loading = 1;
                axios.post('/corp',{stakeholderType:this.form.stakeholderType,cityPlate:this.form.cityPlate.code})
                    .then(function(data){
                        self.corps = data.data;
                        self.loading = 0;
                    });
            }
          },
          getCity(){
              var self = this;
              axios.get('/cities')
                .then(({data})=>{
                    self.cities = data;
                });
          },
          getCountry(){
              var self = this;
              axios.get('/countries')
                .then(({data})=>{
                    self.countries = data;
                });
          },
          getMedicines(){
              var self = this;
              axios.get('/medicine-list')
                  .then(({data})=>{
                      self.medicines = data.medicines;
                      self.groups = data.groups;
                  });
          },
          getFacilities(){
              var self = this;
              axios.get('/facility-list')
                .then(({data})=>{
                    self.facilities = data.facilities;
                });
          },
          getProducts(){
              var self = this;
              axios.get('/products')
                  .then(({data})=>{
                      self.products = data;
                  });
          },
          saveProduct(){
              var self = this;
              let plates = this.form.cityPlate;
              this.form.post('/sale')
                .then(function(data){
                    self.form.cityPlate = plates;
                    self.sonuc(data.status, data.message);
                    self.getProducts();
                })
          },
          detail(product){
              this.selected_product = product;
              this.selected = 1;
          },
          sonuc(status,message){
              Swal.fire({
                icon: status ? 'success' : 'error',
                title: message,
                showConfirmButton: false,
                timer: 2500
            })
          },
          cancel(){
              var self = this;
              Swal.fire({
                title: 'Emin misniz?',
                text: "Ürün İptal Edilecek!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet !',
                cancelButtonText: 'Hayır'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/sale/' + this.selected_product.id)
                            .then(({data})=>{
                                self.sonuc(data.status, data.message);
                            });
                    }
                });
          }
      }
    }
</script>
