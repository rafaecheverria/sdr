<template>

  <div class="wrapper" :class="{'nav-open': $sidebar.showSidebar}">

    <side-bar>

      <user-menu></user-menu>

      <mobile-menu></mobile-menu>

      <template slot="links">

        <sidebar-item :link="{name: 'Dashboard', icon: 'nc-icon nc-chart-pie-35', path: '/'}">
        
        </sidebar-item>

        <sidebar-item :link="{name: 'Components', icon: 'nc-icon nc-app'}">

        </sidebar-item>

      </template>

    </side-bar>
    
    <div class="main-panel">
      <top-navbar></top-navbar>
      
      <dashboard-content @click.native="toggleSidebar">

      </dashboard-content>

    </div>

  </div>

</template>

<script>
  import TopNavbar from './TopNavbar.vue'
  import DashboardContent from './Contenido.vue'
  import MobileMenu from './Extra/MobileMenu.vue'
  import UserMenu from './Extra/UserMenu.vue'
  export default {
    components: {
      TopNavbar,
      DashboardContent,
      MobileMenu,
      UserMenu
    },
    methods: {
      toggleSidebar () {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false)
        }
      }
    }
  }

</script>
