<template>
    <q-drawer
      v-model="leftDrawerOpen"
      :width="350"
      :breakpoint="400"
    >
      <q-list>
        <q-item-label
          header
        >
          <q-avatar class="mr-30 user-img-sidebar" size="50px">
            <img src="~assets/images/preset/dog.png" alt="">
          </q-avatar>
          <span>Kenny Ongko</span>
        </q-item-label>

        <q-card class="item-wrapper">
          <q-card-section>
            Menu
          </q-card-section>
          <q-card-section class="p-0">
              <EssentialLink
              v-for="link in essentialLinks"
              :key="link.title"
              v-bind="link"
            />
          </q-card-section>
        </q-card>
      </q-list>
    </q-drawer>
</template>

<script>
import EssentialLink from 'components/EssentialLink'

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

/* eslint-disable */
export default {
    components: {
        EssentialLink
    },
    data() {
        return {
            essentialLinks: linksList,
            leftDrawerOpen: true
        }
    }
}
</script>
