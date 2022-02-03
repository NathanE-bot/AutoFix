<template>
  <q-layout view="lHh Lpr lFf" v-if="forLoad">
    <!-- Header -->
    <app-header />

    <q-page-container class="p-bg">
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
/* eslint-disable */
import Auth from '../js/AuthValidation'
import Swal from 'sweetalert2'
import Header from 'components/Header'

export default {
  components: {
    appHeader: Header
  },
  data () {
    return {
      forLoad: true
    }
  },
  methods: {
    changePage (url) {
      this.$router.push(url)
    }
  },
  watch: {
  '$route.path': {
    handler: function(url) {
      if(Auth.isUserLogin()){
        if(Auth.userRoleType() !== 'customer'){
          this.forLoad = false
          if(Auth.userRoleType() == 'workshop admin'){
            this.changePage('/admin/workshop/home')
            setTimeout(() => {
              this.forLoad = true
            }, 2000)
          } else if (Auth.userRoleType() == 'insurance admin'){
            this.changePage('/admin/insurance/home')
            setTimeout(() => {
              this.forLoad = true
            }, 2000)
          }
        }
      }
      if(url.includes('/insurance')){
        if(!Auth.isUserLogin()){
          this.forLoad = false
          Swal.fire({
            title: 'Error',
            text: 'Please login first.',
            confirmButtonText: 'Login',
            confirmButtonColor: '#21a17b',
            showCancelButton: true,
            cancelButtonText: 'Back',
          }) .then((result) => {
            if(result.isConfirmed){
              this.changePage('/session/login')
              setTimeout(() => {
                this.forLoad = true
              }, 500)
            } else {
              this.changePage('/')
              setTimeout(() => {
                this.forLoad = true
              }, 500)
            }
          })
        }
      }
    },
    deep: true,
    immediate: true
    }
  }
}
</script>
