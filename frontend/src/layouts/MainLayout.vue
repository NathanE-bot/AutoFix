<template>
  <q-layout view="lHh Lpr lFf">
    <!-- Header -->
    <app-header />

    <q-page-container class="p-bg">
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
/* eslint-disable */
import Header from 'components/Header'

export default {
  components: {
    appHeader: Header
  }
}
</script>
