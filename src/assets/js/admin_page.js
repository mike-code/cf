import Vue from 'vue'

Vue.component('admin-form', require('./Components/AdminPage.vue').default);

new Vue({ el: '#admin-form' });
