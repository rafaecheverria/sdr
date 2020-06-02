require('./bootstrap');

window.Vue = require('vue');

import LightBootstrap from './light-bootstrap-main'

Vue.use(LightBootstrap)

Vue.component('page-home', require('./views/Home.vue').default)
Vue.component('page-departamentos', require('./pages/Departamento.vue').default)
Vue.component('page-cargos', require('./pages/Cargo.vue').default)
Vue.component('page-vacantes', require('./pages/Vacante.vue').default)
Vue.component('page-usuarios', require('./pages/Usuarios.vue').default)
Vue.component('page-roles', require('./pages/Roles.vue').default)
Vue.component('page-permisos', require('./pages/Permisos.vue').default)
Vue.component('page-moderadores', require('./pages/Moderador.vue').default)
Vue.component('page-permisos', require('./pages/Permisos.vue').default)
Vue.component('page-funcionario', require('./pages/Funcionario.vue').default)
Vue.component('page-form-documento', require('./pages/FormDocumento.vue').default)
Vue.component('page-documento', require('./pages/Documento.vue').default)
Vue.component('page-archivador', require('./pages/Archivador.vue').default)
Vue.component('ver-documento', require('./pages/VerDocumento.vue').default)


const app = new Vue({
  el: '#app',
  data:{
    menu: 0,
  },
})
