/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('bootstrap');

window.Vue = require('vue');
import Vuex from 'vuex';

Vue.use(Vuex);

import storeData from './store';
let customerStore =  new Vuex.Store(storeData);

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

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
Vue.component('form-new', require('./components/form/form-new.vue').default);
Vue.component('form-edit', require('./components/form/form-edit.vue').default);
Vue.component('form-payment', require('./components/form/form-payment').default);
Vue.component('form-sign', require('./components/form/form-sign').default);
Vue.component('form-refund', require('./components/form/form-refund').default);
Vue.component('form-refund-items', require('./components/form/form-refund-items').default);
Vue.component('form-social', require('./components/form/form-social').default);
Vue.component('form-travel_fee', require('./components/form/form-travel_fee').default);
Vue.component('form-travel_grant', require('./components/form/form-travel_grant').default);

Vue.component('form-list', require('./components/form/form-list').default);


/*login*/
Vue.component('login', require('./components/login').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: customerStore
});
