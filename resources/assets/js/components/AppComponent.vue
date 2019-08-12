<!-- Este archivo sera la plantilla principal del sistema -->
<template>

  <div :class="{'nav-open': $sidebar.showSidebar}">
    <router-view></router-view>
  </div>

</template>

<script>
  export default {}
</script>
<style>
</style>