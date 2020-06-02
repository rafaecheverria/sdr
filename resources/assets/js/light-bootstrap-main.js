import './polyfills'
// Plugin de notificaciones. Utilizado en la página de notificaciones
// Complemento de validación utilizado para validar formularios
import VeeValidate from 'vee-validate'
// Un archivo de complemento donde se podrían registrar los componentes globales utilizados en la aplicación.
import GlobalComponents from './globalComponents'
// Un archivo de plugin donde podrías registrar directivas globales.
import GlobalDirectives from './globalDirectives'
// Barra lateral a la derecha. Se utiliza como un complemento local en DashboardLayout.vue
import NotificationPlugin from './components/NotificationPlugin'
// Tabs plugin. Utilizado en la página de paneles.
import VueTabs from 'vue-nav-tabs'


// elemento ui configuración de idioma
import lang from 'element-ui/lib/locale/lang/es'
import locale from 'element-ui/lib/locale'
locale.use(lang)

// importaciones de activos
import 'bootstrap/dist/css/bootstrap.css'
import 'vue-nav-tabs/themes/vue-tabs.scss'
import './assets/sass/light-bootstrap-dashboard.scss'
// import './assets/css/demo.css'
import 'element-ui/lib/theme-chalk/index.css'
import './assets/css/styles.css'

export default {
  async install (Vue) {
    Vue.use(GlobalComponents)
    Vue.use(GlobalDirectives)
    Vue.use(NotificationPlugin)
    Vue.use(VueTabs)
    Vue.use(VeeValidate)
  }
}