<template>
  <q-layout view="lHh Lpr lFf" v-if="forLoad">
    <!-- Header -->
    <app-header />

    <!-- Footer -->
    <app-footer />

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
import Footer from 'components/Footer'

export default {
  components: {
    appHeader: Header,
    appFooter: Footer
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
            icon: 'warning',
            title: 'Please login first',
            confirmButtonText: 'Login',
            confirmButtonColor: '#21a17b',
            cancelButtonText: 'Back',
            showCancelButton: true,
            reverseButtons: true,
            customClass: {
              confirmButton: 'br-25px-i py-5-i px-20-i',
              cancelButton: 'br-25px-i py-5-i px-20-i'
            }
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
