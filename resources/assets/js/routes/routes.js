
import Vue from "vue"

import Router from 'vue-router'

import NotFound from '@/pages/GeneralViews/NotFoundPage.vue'

Vue.use(Router)

const Home = () => import('@/views/Home.vue')
const Empresa = () => import('@/pages/Empresa.vue')
const Cargo = () => import('@/pages/Cargo.vue')
const Vacante = () => import('@/pages/Vacante.vue')
const Postulante = () => import('@/pages/Postulacion.vue')
const Login = () => import('@/views/Login.vue')


    export default new Router({
      routes:[
        {
          path: '/',
          name: 'home',
          component: Home
        },
        {
          path: 'empresas',
          name: 'empresas',
          component: Empresa
        },
        {
          path: 'cargos',
          name: 'Cargos',
          component: Cargo
        },
        {
          path: 'vacantes',
          name: 'Vacantes',
          component: Vacante
        },
    
        {
          path: 'postulaciones',
          name: 'Postulacion',
          component: Postulante
        },
        {
          path: 'login',
          name: 'login',
          component: Login
        },

        {path: '*', component: NotFound},

      ],
      
    linkActiveClass: 'active',
    mode: 'history',
    })
     


  


