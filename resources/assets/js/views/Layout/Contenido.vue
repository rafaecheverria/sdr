<template>

  <div class="content">

    <div class="container-fluid">

      <transition name="fade" mode="out-in">

        <!-- your content here -->

        <router-view></router-view>

        <span>Hola contenido</span>

      </transition>

    </div>

  </div>

</template>

<script>
  export default {}
</script>

<style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity .1s
  }

  .fade-enter,
  .fade-leave-to
    /* .fade-leave-active in <2.1.8 */

  {
    opacity: 0
  }
</style>