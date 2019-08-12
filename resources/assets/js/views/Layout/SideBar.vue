<template>
     <div class="wrapper" :class="{'nav-open': $sidebar.showSidebar}">
    <side-bar>
      <user-menu></user-menu>
      <mobile-menu></mobile-menu>
      <template slot-scope="props" slot="links">
        <sidebar-item :link="{name: 'Dashboard', icon: 'nc-icon nc-chart-pie-35', path: '/'}">
        </sidebar-item>
        <sidebar-item :link="{name: 'Components', icon: 'nc-icon nc-app'}">
          <sidebar-item :link="{name: 'Buttons', path: '/components/buttons'}"></sidebar-item>
          <sidebar-item :link="{name: 'Grid System', path: '/components/grid-system'}"></sidebar-item>
          <sidebar-item :link="{name: 'Panels', path: '/components/panels'}"></sidebar-item>
          <sidebar-item :link="{name: 'Sweet Alert', path: '/components/sweet-alert'}"></sidebar-item>
          <sidebar-item :link="{name: 'Notifications', path: '/components/notifications'}"></sidebar-item>
          <sidebar-item :link="{name: 'Icons', path: '/components/icons'}"></sidebar-item>
          <sidebar-item :link="{name: 'Typography', path: '/components/typography'}"></sidebar-item>
        </sidebar-item>
        </template>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>
    </div>

     </div>
</template>

<script>

  import TopNavbar from './TopNavbar.vue'
  import MobileMenu from './Extra/MobileMenu.vue'
  import UserMenu from './Extra/UserMenu.vue'
  export default {
    components: {
      TopNavbar,
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
<style>

</style>