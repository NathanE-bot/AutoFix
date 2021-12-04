<template>
  <q-layout view="lHh Lpr lFf">
    <!-- Header -->
    <app-header />

    <!-- Sidebar -->
    <app-sidebar />

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
      isDisabled: false
    }
  }
}
</script>
