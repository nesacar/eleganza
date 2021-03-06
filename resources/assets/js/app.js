
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('imageUpload', require('./components/imageUpload.vue'));
Vue.component('excelTable', require('./components/excelTable.vue'));
Vue.component('product', require('./components/product.vue'));
Vue.component('imagePreview', require('./components/imagePreview.vue'));
Vue.component('imageNoPreview', require('./components/imageNoPreview.vue'));
Vue.component('date-picker', require('vue-bootstrap-datetimepicker'));

Vue.component('cart', require('./components/cart/cart.vue'));
Vue.component('product', require('./components/cart/product.vue'));

const app = new Vue({
    el: '#app'
});
