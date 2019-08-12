require('./bootstrap');

window.Vue = require('vue');

import LightBootstrap from './light-bootstrap-main'

Vue.use(LightBootstrap)

Vue.component('page-home', require('./views/Home.vue').default)
Vue.component('page-empresas', require('./pages/Empresa.vue').default)
Vue.component('page-cargos', require('./pages/Cargo.vue').default)
Vue.component('page-vacantes', require('./pages/Vacante.vue').default)
Vue.component('page-usuarios', require('./pages/Usuarios.vue').default)
Vue.component('page-roles', require('./pages/Roles.vue').default)
Vue.component('page-permisos', require('./pages/Permisos.vue').default)
Vue.component('page-postulantes', require('./pages/Postulante.vue').default)
Vue.component('page-moderadores', require('./pages/Moderador.vue').default)
Vue.component('page-curriculum', require('./pages/Curriculum.vue').default)
Vue.component('page-permisos', require('./pages/Permisos.vue').default)

const app = new Vue({
  el: '#app',
  data:{
    menu: 0,
  },
})
