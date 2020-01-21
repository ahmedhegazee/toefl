/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import BootstrapVue from 'bootstrap-vue';
require('./bootstrap');

window.Vue = require('vue');
Vue.use(BootstrapVue);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExamsPanel.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('exams-panel', require('./components/ExamsPanel.vue').default);
Vue.component('certificate-panel', require('./components/CertificatePanel.vue').default);
Vue.component('marks-panel', require('./components/MarksPanel.vue').default);
Vue.component('users-panel', require('./components/UsersPanel.vue').default);
Vue.component('students-panel', require('./components/StudentsPanel.vue').default);
Vue.component('configs-panel', require('./components/ConfigsPanel.vue').default);
Vue.component('reservations-panel', require('./components/ReservationsPanel.vue').default);
Vue.component('groups-panel', require('./components/GroupsPanel.vue').default);
Vue.component('display-exams-panel', require('./components/DisplayExamsPanel.vue').default);
Vue.component('display-students-panel', require('./components/StudentsDisplayPanel.vue').default);
Vue.component('display-questions-panel', require('./components/DisplayQuestionsPanel.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
