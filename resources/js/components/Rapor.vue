<template>
<div>
    <div class="card" id="rapor">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="S" v-model="form.type" id="city">
                        <label class="form-check-label" for="city">
                            İllere Göre
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="U" type="radio" v-model="form.type" id="product">
                        <label class="form-check-label" for="product">
                            Ürünlere Göre
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label>Başlangıç Tarihi</label>
                        <datetime type="date" input-class="form-control"
                                  v-model="form.start"
                                  format="dd/MM/yyyy" :auto='true'
                                  :phrases="{ok: 'Tamam', cancel: 'iptal'}"
                                  value-zone="Europe/Istanbul"></datetime>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label>Bitiş Tarihi</label>
                        <datetime type="date" input-class="form-control"
                                  v-model="form.end"
                                  format="dd/MM/yyyy" :auto='true'
                                  :phrases="{ok: 'Tamam', cancel: 'iptal'}"
                                  value-zone="Europe/Istanbul"></datetime>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label>Aktivite</label>
                        <select v-model="form.unit_id" class="form-control">
                            <option>Seçin</option>
                            <option value="1">&#181;ci</option>
                            <option value="2">mci</option>
                            <option value="3">mbq</option>
                            <option value="4">gbq</option>
                            <option value="5">kutu/vial</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9" v-if="form.type === 'S'">
                    <div class="form-group">
                        <label class='form-label'>İl</label>
                        <v-select label="city" v-model="form.city" :options="cities"></v-select>
                    </div>
                </div>
                <div class="col-md-9" v-if="form.type === 'U'">
                    <div class="form-group">
                        <label class='form-label'>Ürün</label>
                        <select v-model='form.medicine' class="form-control">
                            <optgroup v-for='group in groups' :label="group.name">
                                <option v-for="option in medicines" :value="option.barcode"
                                        v-if='group.group === option.group'>
                                    {{ option.medicine }}
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-right mt-3">
                <a href="javascript:void(0);" @click="getReport" class="btn btn-primary btn-icon waves-effect waves-themed"><i class="fal fa-search"></i></a>
            </div>
        </div>
    </div>
    <div class="card mt-3" v-if="results.length > 0">
        <div class="card-body">
            <h4 class="card-title">Sonuçlar</h4>
            <table>
                <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>Parti No</th>
                        <th>Kurum</th>
                        <th>Üretim Tesisi</th>
                        <th>Yüklenen Aktivite</th>
                        <th>Hedeflenen Aktivite</th>
                        <th>Yükleme Tarihi</th>
                        <th>DT</th>
                        <th>Ülke Kodu</th>
                        <th>Son Kullanım Tarihi</th>
                        <th>Teslim Tarihi</th>
                        <th>Onay</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for='(product,index) in results' :key="index">
                        <td>
                            {{ product.gtin }}
                        </td>
                        <td>{{ product.bn }}</td>
                        <td>{{ product.corp }}</td>
                        <td>{{ product.production_identifier }}</td>
                        <td v-html="product.loaded_activity+' '+product.loaded_unit_id">
                            {{ product.loaded_activity }}
                        </td>
                        <td v-html="product.calibration_activity+' '+product.calibration_unit_id"></td>
                        <td>{{ product.load_date }}</td>
                        <td>{{ product.dt }}</td>
                        <td>{{ product.country_code }}</td>
                        <td>{{ product.xd }}</td>
                        <td>{{ product.delivery }}</td>
                        <td>
                            <span v-if="product.cancel_date">{{ product.cancel_date }} tarihinde iptal edildi</span>
                            <span v-else class="text-red"><i :class="[product.uc === '00000' ? 'fal fa-2x fa-check green' : 'fal fa-2x fa-times red']"></i></span>
                        </td>
                    </tr>
                </tbody>
            </table>
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
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'


export default {
    props:['cities','groups','medicines'],
    data(){
        return {
            results:[],
            form:new Form({
                start:null,
                end:null,
                unit_id:null,
                type:null,
                city:null,
                medicine:null,
            }),
        }
    },
    methods:{
        getReport(){
            let self=this;
            let start=this.form.start;
            let end=this.form.end;
            let unit_id= this.form.unit_id;
            let type= this.form.type;
            let city= this.form.city;
            let medicine= this.form.medicine;
            this.form.post('/reports')
                .then(function(result){
                    console.log(result);
                    self.form.start = start;
                    self.form.end = end;
                    self.form.unit_id = unit_id;
                    self.form.type = type;
                    self.form.city = city;
                    self.form.medicine = medicine;
                    self.results = result;
                });
        }
    }
}
</script>

<style scoped>

</style>
