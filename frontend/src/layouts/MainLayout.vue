<template>
  <q-layout view="lHh Lpr lFf">
    <!-- Header -->
    <app-header />

    <!-- Sidebar -->
    <!-- <app-sidebar /> -->

    <q-page-container class="p-bg">
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
/* eslint-disable */

import Header from 'components/Header'
import Sidebar from 'components/Sidebar'

export default {
  // name: 'MainLayout',

  components: {
    appHeader: Header,
    appSidebar: Sidebar
  },
  data () {
    return {
    }
  },
  computed: {

  },
  methods: {
    doConsole (a) {
      console.log(a)
    }
  }
  // watch: {
  // '$route.meta.title': {
  //     handler: function(search) {
  //       // console.log(search)
  //       if(search === 'Login' || search === 'Register') this.forHeaderSession = false
  //       else this.forHeaderSession = true
  //       if(search === 'Login' || search === 'Register' || search === 'Landing Page')  this.forSidebarSession = false
  //       else this.forSidebarSession = false
  //       // console.log('hed', this.forHeaderSession, this.forSidebarSession)
  //     },
  //     deep: true,
  //     immediate: true
  //   }
  // }
}
</script>
