<template>
  <q-layout view="lHh Lpr lFf">
    <!-- Header -->
    <app-header v-if="forHeaderSession" />

    <!-- Sidebar -->
    <app-sidebar v-if="forSidebarSession" />

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
      forHeaderSession: false,
      forSidebarSession: false,
    }
  },
  computed: {

  },
  methods: {
    // doCheckUrl () {
    //   let search = $route.meta.title
    //   if(search === 'Login' || search === 'Register' || search === 'Landing Page') this.forHeaderSession = true
    //   else if (search === 'Login' || search === 'Register') this.forSidebarSession = true
    //   else this.forSidebarSession = true, this.forHeaderSession = true
    //   console.log('hed', this.forHeaderSession, this.forSidebarSession)
    // },
    doConsole (a) {
      console.log(a)
    }
  },
  watch: {
  '$route.meta.title': {
      handler: function(search) {
        console.log(search)
        if(search === 'Login' || search === 'Register') this.forHeaderSession = false
        else this.forHeaderSession = true
        if(search === 'Login' || search === 'Register' || search === 'Landing Page')  this.forSidebarSession = false
        else this.forSidebarSession = false
        console.log('hed', this.forHeaderSession, this.forSidebarSession)
      },
      deep: true,
      immediate: true
    }
  }
}
</script>
