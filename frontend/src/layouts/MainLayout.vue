<template>
  <q-layout view="lHh Lpr lFf">
    <q-header class="autorepair-header">
      <q-toolbar>
        <q-btn
          v-if="isDisabled"
          @click="toggleLeftDrawer"
          flat dense round
          icon="menu"
          aria-label="Menu"
        />
        <div class="relative-box">
          <img class="logo-img" src="../assets/images/logo.png" alt="">
        </div>
        <q-tabs
          v-model="initialTab"
          dense
          class="m-auto"
          active-color="primary"
          indicator-color="primary"
          align="justify"
        >
          <q-tab name="home" label="Home" />
          <q-tab name="workshop" label="Workshop" />
          <q-tab name="insurance" label="Insurance" />
          <q-tab name="aboutus" label="About Us" />
        </q-tabs>
        <div class="relative-position">
          <div class="d-flex a-center">
            <q-btn
              outline
              rounded
              color="primary"
              class="tf-capitalize mr-10 fw lg-rg-btn"
            >
              Login
            </q-btn>
            <q-btn
              unelevated
              rounded
              color="primary"
              class="tf-capitalize fw lg-rg-btn"
            >
              Register
            </q-btn>
          </div>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      bordered
    >
      <q-list>
        <q-item-label
          header
        >
          Essential Links
        </q-item-label>

        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
/* eslint-disable */
import EssentialLink from 'components/EssentialLink.vue'

const linksList = [
  {
    title: 'Docs',
    caption: 'quasar.dev',
    icon: 'school',
    link: 'https://quasar.dev'
  },
  {
    title: 'Github',
    caption: 'github.com/quasarframework',
    icon: 'code',
    link: 'https://github.com/quasarframework'
  },
  {
    title: 'Discord Chat Channel',
    caption: 'chat.quasar.dev',
    icon: 'chat',
    link: 'https://chat.quasar.dev'
  },
  {
    title: 'Forum',
    caption: 'forum.quasar.dev',
    icon: 'record_voice_over',
    link: 'https://forum.quasar.dev'
  },
  {
    title: 'Twitter',
    caption: '@quasarframework',
    icon: 'rss_feed',
    link: 'https://twitter.quasar.dev'
  },
  {
    title: 'Facebook',
    caption: '@QuasarFramework',
    icon: 'public',
    link: 'https://facebook.quasar.dev'
  },
  {
    title: 'Quasar Awesome',
    caption: 'Community Quasar projects',
    icon: 'favorite',
    link: 'https://awesome.quasar.dev'
  }
]

export default {
  // name: 'MainLayout',

  components: {
    EssentialLink
  },

  mounted () {
    console.log(this.leftDrawerOpen)
  },

  data() {
    return {
      initialTab: 'home',
      leftDrawerOpen: false,
      isDisabled: false,
      essentialLinks: linksList
    }
  },
  methods: {
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    }
  }
}
</script>
