<template>
  <div class="row">
    <div class="col-lg-9 col-md-8">
      <editar-form :auth="auth">

      </editar-form>
    </div>
    <div class="col-lg-3 col-md-4">
      <user-card>

      </user-card>
    </div>
  </div>
</template>
<script>
  import EditarForm from './UserProfile/EditarForm.vue'
  import UserCard from './UserProfile/UserCard.vue'

  export default {
       props: [
        'auth'
    ],
    components: {
      EditarForm,
      UserCard
    }
  }

</script>
<style>

</style>
