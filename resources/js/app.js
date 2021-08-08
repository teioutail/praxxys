require('./bootstrap');

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

// include from vue router
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// Include Noty
import VueNoty from 'vuejs-noty'
Vue.use(VueNoty)
import 'vuejs-noty/dist/vuejs-noty.css'
import Notification from './Helpers/Notification'
import Common from './Helpers/Notification'

// create instance
window.Notification = Notification
window.Common = Common



// Router Imported
import {routes} from './routes'

const router = new VueRouter({
    //  routes short for `routes: routes`
    routes,
    mode: 'history'
})

// Import SweetAlert Start
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

window.Toast = Toast;
// Sweet Alert End


const app = new Vue({
    router
  }).$mount('#app')
