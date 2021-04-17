/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueToast from 'vue-toast-notification';
Vue.use(VueToast);
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('password', require('./components/Password.vue').default);

Vue.component('users', require('./components/admin/User.vue').default);
Vue.component('agencies', require('./components/admin/Agencies.vue').default);
Vue.component('dropdownlists', require('./components/admin/Dropdownlists.vue').default);
Vue.component('testservices', require('./components/admin/Testservices.vue').default);
Vue.component('packages', require('./components/admin/Packages.vue').default);
Vue.component('addons', require('./components/admin/Addons.vue').default);

Vue.component('customers', require('./components/cro/Customer.vue').default);
Vue.component('customer-create', require('./components/cro/CustomerCreate.vue').default);
Vue.component('requests', require('./components/cro/Request.vue').default);
Vue.component('request-create', require('./components/cro/RequestCreate.vue').default);
Vue.component('request-create-referral', require('./components/cro/RequestCreateReferral.vue').default);
Vue.component('request-view', require('./components/cro/RequestView.vue').default);
Vue.component('request-sample', require('./components/cro/RequestSample.vue').default);
Vue.component('request-analysis', require('./components/cro/RequestAnalysis.vue').default);
Vue.component('request-new-analysis', require('./components/cro/RequestNewAnalysis.vue').default);
Vue.component('cro', require('./components/cro/Home.vue').default);
Vue.component('report', require('./components/cro/Report.vue').default);

Vue.component('orseries', require('./components/finance/Orseries.vue').default);
Vue.component('orderofpayment', require('./components/finance/Orderofpayment.vue').default);
Vue.component('types', require('./components/finance/Type.vue').default);
Vue.component('finance', require('./components/finance/Home.vue').default);

Vue.component('analyst', require('./components/analyst/Home.vue').default);
Vue.component('analyst-samples', require('./components/analyst/Sample.vue').default);

const app = new Vue({
    el: '#app',
});
