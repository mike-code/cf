import Vue from 'vue'

Vue.component('loan-form', require('./Components/LoanForm.vue').default);

new Vue({ el: '#loan-form' });
