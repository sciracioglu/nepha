/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Form from './components/utilities/Form';
window.Form = Form;

import { Datetime } from 'vue-datetime';

Vue.component('datetime', Datetime);
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('product-list', require('./components/ProductList.vue').default);
Vue.component('medicine', require('./components/Medicine.vue').default);
Vue.component('facility', require('./components/Facility.vue').default);
Vue.component('user', require('./components/User.vue').default);

const app = new Vue({
    el: '#app',
});
