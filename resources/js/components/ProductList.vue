<template>
    <div v-cloak>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel" v-if='products.length > 0 && new_form === 0 && selected === 0'>
                    <div class="panel-hdr">
                        <h2>Tanımlı Ürünler</h2>
                        <div class="panel-toolbar">
                            <button type="button" @click="new_form=1"
                                    class="btn btn-icon btn-sm btn-secondary mr-1 shadow-0 waves-effect waves-themed">
                                <i class="fal fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <vue-good-table
                                :columns="colums"
                                :rows="products"
                                :search-options="{
                                    enabled: true,
                                }"
                                :pagination-options=" {
                                  enabled: true,
                                  firstRecordOnPage: 'İlk sayfa',
                                  lastRecordOnPage: 'Son sayfa',
                                  totalRecords: 'Toplam kayıt sayısı',
                                  currentPage: 'şu anki sayfa',
                                  totalPage: 'toplam sayfa sayısı',
                                }">
                            </vue-good-table>
                        </div>
                    </div>
                </div>
                <div class="panel" v-if='products.length === 0 || new_form && selected === 0' v-cloak>
                    <div class="panel-hdr">
                        <h2>İTS'ye Bildir</h2>
                        <div class="panel-toolbar" v-if='products.length > 0'>
                            <button type="button" @click="new_form = 0" data-action="panel-close"
                                    class="btn btn-sm btn-danger mr-2 btn-icon waves-effect waves-themed">
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
                                            <select v-model='form.stakeholderType' class="form-control"
                                                    @change="getCorp()">
                                                <option value="hastane">Hastane</option>
                                                <option value="uretici">Üretici</option>
                                                <option value="ihracatci">İhracatçı</option>
                                                <option value="depo">Depo</option>
                                                <option value="eczane">Eczane</option>
                                                <option value="geriodemekurumu">Geri Ödeme Kurumu</option>
                                            </select>
                                            <span class="text-danger" v-if="form.errors.has('stakeholderType')">Kurum Tipi zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>İl</label>
                                            <v-select label="city" v-model="form.cityPlate" :options="cities"
                                                      @input="getCorp()"></v-select>
                                            <span class="text-danger" v-if="form.errors.has('cityPlate')">İl zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class='form-label'>Kurum</label>
                                            <span v-if="loading"><i class="fal fa-cog fa-2x fa-spin"></i></span>
                                            <v-select v-else label="label" v-model="form.togln"
                                                      :options="corps"></v-select>
                                            <span class="text-danger"
                                                  v-if="form.errors.has('togln')">TOGLN Zorunlu alan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Ürün</label>
                                            <select v-model='form.gtin' class="form-control">
                                                <optgroup v-for='group in groups' :label="group.name">
                                                    <option v-for="option in medicines" :value="option.barcode"
                                                            v-if='group.group === option.group'>
                                                        {{ option.medicine }}
                                                    </option>
                                                </optgroup>
                                            </select>
                                            <span class="text-danger"
                                                  v-if="form.errors.has('gtin')">GTIN Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Parti No</label>
                                            <input type="text" v-model="form.bn" class="form-control"/>
                                            <span class="text-danger"
                                                  v-if="form.errors.has('bn')">BN Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Üretim Tesisi</label>
                                            <select class="form-control" v-model='form.production_identifier'
                                                    @change="setCountry($event)">
                                                <option v-for='facility in facilities' :value='facility.facility'>
                                                    {{ facility.facility }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Teslim Tarihi</label>
                                            <datetime v-model="form.delivery" type="date" input-class="form-control"
                                                      format="dd/MM/yyyy" :auto='true'
                                                      :phrases="{ok: 'Tamam', cancel: 'iptal'}"
                                                      value-zone="Europe/Istanbul"></datetime>
                                            <span class="text-danger" v-if="form.errors.has('delivery')">Teslim Tarihi Zorunlu alan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Yüklenen Aktivite Birimi</label>
                                            <select v-model="form.loaded_unit_id" class="form-control" @change="birim()">
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
                                            <label class='form-label'>Yüklenen Aktivite</label>
                                            <input type="text" v-model="form.loaded_activity" class="form-control"/>
                                            <span class="text-danger" v-if="form.errors.has('loaded_activity')">Yüklenen Aktivite Zorunlu alan</span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Hedeflenen Aktivite</label>
                                            <input type="text" v-model="form.calibration_activity"
                                                   class="form-control"/>
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
                                            <datetime v-model="form.load_date" type="date" input-class="form-control"
                                                      format="dd/MM/yyyy" :auto='true'
                                                      :phrases="{ok: 'Tamam', cancel: 'iptal'}"
                                                      value-zone="Europe/Istanbul"></datetime>
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
                                            <span class="text-danger"
                                                  v-if="form.errors.has('dt')">DT Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Ülke</label>
                                            <v-select label="country" v-model="form.country_code"
                                                      :options="countries"></v-select>
                                            <span class="text-danger" v-if="form.errors.has('country_code')">Ülke Zorunlu alan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class='form-label'>Son Kullanma Tarihi</label>
                                            <datetime v-model="form.xd" type="datetime" :minute-step="30"
                                                      input-class="form-control" format="dd/MM/yyyy HH:mm" :auto='true'
                                                      :phrases="{ok: 'Tamam', cancel: 'iptal'}"
                                                      value-zone="Europe/Istanbul"></datetime>
                                            <span class="text-danger" v-if="form.errors.has('xd')">Son Kullanma Tarihi Zorunlu alan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6" style="text-align:right;">
                                        <button type="submit"
                                                class="btn btn-primary btn-lg btn-icon rounded-circle hover-effect-dot waves-effect waves-themed">
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
                            <button type="button" @click="selected = 0; selected_product = [];"
                                    data-action="panel-close"
                                    class="btn btn-sm btn-danger mr-2 btn-icon waves-effect waves-themed">
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
                                    <th>Kurum</th>
                                    <td>: {{ selected_product.corp }}</td>
                                </tr>
                                <tr>
                                    <th>Üretim Tesisi</th>
                                    <td>: {{ selected_product.production_identifier }}</td>
                                </tr>
                                <tr>
                                    <th>Yüklenen Aktivite</th>
                                    <td v-html="':'+selected_product.loaded_activity+' '+selected_product.loaded_unit_id"></td>
                                </tr>
                                <tr>
                                    <th>Hedeflenen Aktivite</th>
                                    <td v-html="':'+selected_product.calibration_activity+' '+selected_product.calibration_unit_id"></td>
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
                                    <td>Teslim Tarihi</td>
                                    <td>: {{ selected_product.delivery }}</td>
                                </tr>
                                <tr>
                                    <th>Onay</th>
                                    <td>:
                                        <span v-if="selected_product.cancel_date">{{ selected_product.cancel_date }} tarihinde iptal edildi</span>
                                        <span v-else>{{ selected_product.uc }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6" style="text-align: right;">
                                    <button type="button" @click='cancel()'
                                            class="btn btn-danger btn-lg btn-icon rounded-circle hover-effect-dot waves-effect waves-themed">
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
import 'vue-select/dist/vue-select.css';
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.component('v-select', vSelect)

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
    data() {
        return {
            loading: 0,
            new_product: 0,
            new_form: 0,
            search: '',
            products: [],
            selected: 0,
            selected_product: [],
            cities: [],
            corps: [],
            countries: [],
            medicines: [],
            colums: [
                {
                    label: 'Ürün',
                    field: 'gtin'
                },
                {
                    label: 'Parti No',
                    field: 'bn'
                },
                {
                    label: 'Kurum',
                    field: 'corp'
                },
                {
                    label: 'Üretim Tesisi',
                    field: 'production_identifier'
                },
                {
                    label: 'Yüklenen Aktivite',
                    field: 'loaded_activity'
                },
                {
                    label: 'Hedeflenen Aktivite',
                    field: 'calibration_activity'
                },
                {
                    label: 'Yükleme Tarihi',
                    field: 'load_date'
                },
                {
                    label: 'DT',
                    field: 'dt'
                },
                {
                    label: 'Ülke Kod',
                    field: 'country_code'
                },
                {
                    label: 'Son Kullanım Tarihi',
                    field: 'xd'
                },
                {
                    label: 'Teslim Tarihi',
                    field: 'delivery'
                },
                {
                    label: 'Onay',
                    field: 'uc'
                },
            ],
            groups: [],
            facilities: [],
            form: new Form({
                stakeholderType: 'hastane',
                getAll: false,
                cityPlate: {
                    city: "Ankara",
                    code: "06",
                    id: 6,
                },
                togln: null,
                gtin: null,
                bn: null,
                delivery: null,
                production_identifier: null,
                loaded_activity: null,
                loaded_unit_id: null,
                calibration_activity: null,
                calibration_unit_id: null,
                load_date: null,
                dt: "I",
                country_code: {
                    code2: 'NL',
                    code3: 'NLD',
                    country: 'Netherlands (the)',
                    id: 528,
                },
                xd: null,
            }),
        }
    },

    methods: {
        birim() {
            this.form.calibration_unit_id = this.form.loaded_unit_id;
        },
        setCountry(event) {
            this.form.country_code = this.facilities[event.target.selectedIndex].country;
        },
        getCorp() {
            var self = this;
            if (this.form.cityPlate !== '' && this.form.stakeholderType !== '') {
                this.loading = 1;
                axios.post('/corp', {stakeholderType: this.form.stakeholderType, cityPlate: this.form.cityPlate.code})
                    .then(function (data) {
                        self.corps = data.data;
                        self.loading = 0;
                    });
            }
        },
        getCity() {
            var self = this;
            axios.get('/cities')
                .then(({data}) => {
                    self.cities = data;
                });
        },
        getCountry() {
            var self = this;
            axios.get('/countries')
                .then(({data}) => {
                    self.countries = data;
                });
        },
        getMedicines() {
            var self = this;
            axios.get('/medicine-list')
                .then(({data}) => {
                    self.medicines = data.medicines;
                    self.groups = data.groups;
                });
        },
        getFacilities() {
            var self = this;
            axios.get('/facility-list')
                .then(({data}) => {
                    self.facilities = data.facilities;
                });
        },
        getProducts() {
            var self = this;
            axios.get('/products')
                .then(({data}) => {
                    self.products = data;
                });
        },
        saveProduct() {
            if (parseFloat(this.form.loaded_activity) >= parseFloat(this.form.calibration_activity)) {
                let self = this;
                let plates = this.form.cityPlate;
                this.form.post('/sale')
                    .then(function (data) {
                        self.form.cityPlate = plates;
                        self.sonuc(data.status, data.message);
                        self.getProducts();
                    })
            } else {
                Swal.fire('Hata', 'Hedeflenen aktivite, Yüklenen aktivite sayısından büyük olamaz', 'error');
            }

        },
        detail(product) {
            this.selected_product = product;
            this.selected = 1;
        },
        sonuc(status, message) {
            Swal.fire({
                icon: status ? 'success' : 'error',
                title: message,
                showConfirmButton: false,
                timer: 2500
            })
        },
        cancel() {
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
                        .then(({data}) => {
                            self.sonuc(data.status, data.message);
                        });
                }
            });
        }
    }
}
</script>
