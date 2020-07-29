/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

//window.Vue = require('vue');


//Vue.component('example-component', require('./components/ExampleComponent.vue').default);




import PerfectScrollbar from 'perfect-scrollbar';
const ps2 = new PerfectScrollbar('.navbar', {
    wheelSpeed: 2,
    wheelPropagation: true,
    minScrollbarLength: 20
  });
const ps = new PerfectScrollbar('.main-content', {
    wheelSpeed: 2,
    wheelPropagation: true,
    minScrollbarLength: 20
  });
 


