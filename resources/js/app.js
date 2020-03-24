require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import Vuex from 'vuex';
import 'vuetify/dist/vuetify.min.css'
import VueRouter from 'vue-router';

Vue.use(Vuex);
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});
