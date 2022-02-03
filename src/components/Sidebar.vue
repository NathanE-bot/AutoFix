<template>
  <q-drawer
    v-model="leftDrawerOpen"
    :width="350"
    :breakpoint="500"
    style="overflow-y: hidden; overflow-x: hidden;"
  >
    <q-scroll-area
      :thumb-style="thumbStyle"
      :bar-style="barStyle"
      class="list-workshop-scrollbar"
      :style="{height: window.heightAltered + 'px'}"
    >
      <q-list padding class="txt-white">
        <q-item-label
          header
          class="d-flex a-center"
        >
          <q-avatar class="mr-30 user-img-sidebar" size="50px">
            <q-img
              v-if="!help.isDataEmpty(user.profilePicture)"
              :src="user.profilePicture"
              :ratio="1"
              class="responsive_img"
            />
            <i v-else class="fas fa-user grey-5"></i>
          </q-avatar>
          <span class="text-subtitle1 fw-semibold">{{ user.fullName }}</span>
        </q-item-label>
        <q-item-section class="mt-30">
          <q-item-label>
            <span class="text-subtitle1 fw-semibold">Menu</span>
          </q-item-label>

          <!-- <q-item
            clickable
            v-ripple
            :active="link === 'document'"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <is-document />
            </q-item-section>
            <q-item-section>Document</q-item-section>
          </q-item> -->

          <q-item
            clickable
            v-ripple
            :active="link === 'messages'"
            @click="changePage('/member/home-message')"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <is-message />
            </q-item-section>

            <q-item-section>Message</q-item-section>
          </q-item>

          <!-- <q-item
            clickable
            v-ripple
            :active="link === 'feedback'"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <q-icon name="inbox" />
            </q-item-section>

            <q-item-section>Feedback</q-item-section>
          </q-item> -->

          <q-item
            clickable
            v-ripple
            :active="link === 'history'"
            @click="changePage('/member/history-list')"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <is-history />
            </q-item-section>

            <q-item-section>History</q-item-section>
          </q-item>

          <q-item
            clickable
            v-ripple
            :active="link === 'schedule'"
            @click="changePage('/member/schedule-list')"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <is-schedule />
            </q-item-section>

            <q-item-section>Schedule</q-item-section>
          </q-item>

          <q-item
            clickable
            v-ripple
            :active="link === 'favorite'"
            @click="changePage('/member/favorite-list')"
            active-class="my-menu-link"
            class="mb-20"
          >
            <q-item-section avatar>
              <is-favorite />
            </q-item-section>

            <q-item-section>Favorites</q-item-section>
          </q-item>

          <!-- <q-item
            clickable
            v-ripple
            :active="link === 'insurance'"
            active-class="my-menu-link"
            class="mb-20"
          >
            <q-item-section avatar>
              <q-icon name="inbox" />
            </q-item-section>

            <q-item-section>Insurance</q-item-section>
          </q-item> -->

        </q-item-section>
        <q-item-section class="mt-30 ml-0-i">
          <q-item-label>
            <span class="text-subtitle1 fw-semibold">Account</span>
          </q-item-label>
          <q-item
            clickable
            v-ripple
            :active="link === 'profile'"
            @click="changePage('/member/your-account')"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <is-account />
            </q-item-section>

            <q-item-section>Your Profile</q-item-section>
          </q-item>

          <q-item
            clickable
            v-ripple
            :active="link === 'signOut'"
            active-class="my-menu-link"
            class="mb-20"
          >
            <q-item-section avatar>
              <is-logout />
            </q-item-section>

            <q-item-section>Sign Out</q-item-section>
          </q-item>
        </q-item-section>
      </q-list>
    </q-scroll-area>
  </q-drawer>
</template>

<script>
/* eslint-disable */
// SVGs
import isvgDocument from './IconSVG/isvg_document'
import isvgMessage from './IconSVG/isvg_message'
import isvgHistory from './IconSVG/isvg_history'
import isvgSchedule from './IconSVG/isvg_schedule'
import isvgAccount from './IconSVG/isvg_account'
import isvgLogout from './IconSVG/isvg_logout'
import isvgFavorite from './IconSVG/isvg_favorite'
// End of SVGs
import help from '../js/help'
import Auth from '../js/AuthValidation'
import { LocalStorage } from 'quasar'

export default {
  components: {
    // SVGs
    isDocument: isvgDocument,
    isMessage: isvgMessage,
    isHistory: isvgHistory,
    isSchedule: isvgSchedule,
    isAccount: isvgAccount,
    isLogout: isvgLogout,
    isFavorite: isvgFavorite,
    // End of SVGs
    help
  },
  data() {
    return {
      help,
      window: {
        width: 0,
        height: 0,
        heightAltered: 0
      },
      thumbStyle: {
        right: '2px',
        borderRadius: '10px',
        backgroundColor: '#fff',
        width: '15px',
        opacity: 0.75
      },
      barStyle: {
        right: '2px',
        borderRadius: '10px',
        backgroundColor: '#fff',
        width: '15px',
        opacity: 0.2
      },
      user: {},
      leftDrawerOpen: true,
      link: ''
    }
  },
  mounted () {
    if(Auth.isUserLogin){
      this.user = LocalStorage.getItem('autoRepairUser').data.user
    } 
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (10/100))
    },
    changePage (url) {
      this.$router.push(url)
    }
  },
  watch: {
  '$route.path': {
    handler: function(url) {
      if(url.includes('/your-account')){
        this.link = 'profile'
      }
      else if(url.includes('/home-message')){
        this.link = 'messages'
      }
      else if(url.includes('/schedule-list')){
        this.link = 'schedule'
      }
      else if(url.includes('/history-list')){
        this.link = 'history'
      }
      else if(url.includes('/favorite-list')){
        this.link = 'favorite'
      }
    },
    deep: true,
    immediate: true
    }
  }
}
</script>
