// styles
import './../css/app.sass';

// vue
import Vue from 'vue';
window.Vue = Vue;
window.eventHub = new Vue(); // event hub by vue

// axios
import axios from 'axios';
window.axios = axios;

// form class
import Form from './core/Form.js';
window.Form = Form;

// import search component
Vue.component('search-component', require('./components/SearchComponent.vue').default);

// init root vue instance
var app = new Vue({
  el: '#app',
  data: {
  }
});