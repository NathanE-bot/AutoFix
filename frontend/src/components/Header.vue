<template>
    <q-header class="autorepair-header">
      <q-toolbar>
        <div class="relative-box">
          <img class="logo-img fixed-top-left fit-content" src="../assets/images/logo.png" alt="">
        </div>
        <q-tabs
          v-model="initialTab"
          dense
          class="m-auto hide-m"
          active-color="primary"
          indicator-color="primary"
          align="justify"
        >
          <q-tab @click="changePage('/')" name="home" label="Home" />
          <q-tab @click="changePage('/workshop')" name="workshop" label="Workshop" />
          <div class="relative-position">
            <q-tab class="insurance-tab" name="insurance" />
            <q-btn-dropdown
              :color="initialTab == 'insurance' ? 'primary' : ''"
              auto-close flat :ripple="false" :menu-offset="[25, 15]"
              transition-show="jump-down" transition-hide="jump-up" label="Insurance"
              class="tf-capitalize fs-16 dropdown-btn-tab"
              content-class="dropdown-tab text-white"
            >
              <q-list class="dropdown-g">
                <q-item clickable @click="changePage('/insurance/claim-insurance')">
                  <q-item-section>Claim Insurance</q-item-section>
                </q-item>

                <q-item clickable @click="changePage('/insurance/status-insurance')">
                  <q-item-section>Claim Insurance Status</q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </div>
        </q-tabs>
        <div class="relative-position hide-m">
          <div class="float-button">
            <div class="buttons" v-if="!isLogin">
              <q-btn
                @click="changePage('/session/login')"
                outline
                rounded
                color="primary"
                class="tf-capitalize mr-10 fw lg-rg-btn"
              >
                Login
              </q-btn>
              <q-btn
                @click="changePage('/session/register')"
                unelevated
                rounded
                color="primary"
                class="tf-capitalize fw lg-rg-btn"
              >
                Register
              </q-btn>
            </div>
            <div class="login-avatar" v-else>
              <div>
                <q-btn
                  round unelevated
                  color="white"
                  size="md"
                >
                  <q-avatar size="50px" class="bg-white">
                    <q-img
                      v-if="!help.isDataEmpty(user.profilePicture)"
                      :src="user.profilePicture"
                      :ratio="1"
                      class="responsive_img"
                    />
                    <i v-else class="fas fa-user grey-5"></i>
                  </q-avatar>
                  <q-menu
                    class="dropdown-g text-white"
                    style="border-radius: 0px 0px 5px 5px"
                    :offset="[20, 9]"
                  >
                    <q-list style="min-width: 100px">
                      <q-item
                        @click="changePage('/member/your-account')"
                        clickable v-close-popup
                      >
                        Profile
                      </q-item>
                      <q-item
                        @click="doLogout()"
                        clickable v-close-popup>
                        Logout
                      </q-item>
                    </q-list>
                  </q-menu>
                </q-btn>
              </div>
            </div>
          </div>
        </div>
        <!-- mobile -->
        <div class="show-m">
          <div class="m-right-side-wrapper">
            <div class="d-flex m-btns-wrapper" v-if="!isLogin">
              <q-btn
                @click="changePage('/session/login')"
                outline
                rounded
                color="primary"
                class="tf-capitalize mr-10"
              >
                Login
              </q-btn>
              <q-btn
                @click="changePage('/session/register')"
                unelevated
                rounded
                color="primary"
                class="tf-capitalize"
              >
                Register
              </q-btn>
            </div>
            <q-btn
              @click="dialogMobileProfile = true"
              v-else
              round unelevated
              color="white"
              size="md"
            >
              <q-avatar size="50px" class="bg-white">
                <q-img
                  v-if="!help.isDataEmpty(user.profilePicture)"
                  :src="user.profilePicture"
                  :ratio="1"
                  class="responsive_img"
                />
                <i v-else class="fas fa-user grey-5"></i>
              </q-avatar>
            </q-btn>
          </div>
        </div>
        <!-- dialog -->
        <q-dialog
          v-model="dialogMobileProfile"
          persistent maximized
          transition-show="slide-up"
          transition-hide="slide-down"
        >
          <q-card class="bg-dark text-white">
            <q-bar class="mh-70">
              <div class="relative-box">
                <img class="logo-img fixed-top-left fit-content" src="../assets/images/logo.png" alt="">
              </div>
              <q-space />
              <q-btn @click="dialogMobileProfile = false" flat round size="md" icon="close" />
            </q-bar>
            <q-card-section class="m-dialog-mobile-profile">
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

                  <q-item
                    clickable
                    v-ripple
                    :active="initialTab === 'messages'"
                    @click="changePage('/member/home-message')"
                    active-class="my-menu-link"
                  >
                    <q-item-section avatar>
                      <is-message />
                    </q-item-section>

                    <q-item-section>Message</q-item-section>
                  </q-item>

                  <q-item
                    clickable
                    v-ripple
                    :active="initialTab === 'history'"
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
                    :active="initialTab === 'schedule'"
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
                    :active="initialTab === 'favorite'"
                    @click="changePage('/member/favorite-list')"
                    active-class="my-menu-link"
                    class="mb-20"
                  >
                    <q-item-section avatar>
                      <is-favorite />
                    </q-item-section>

                    <q-item-section>Favorites</q-item-section>
                  </q-item>

                </q-item-section>
                <q-item-section class="mt-30 ml-0-i">
                  <q-item-label>
                    <span class="text-subtitle1 fw-semibold">Account</span>
                  </q-item-label>
                  <q-item
                    clickable
                    v-ripple
                    :active="initialTab === 'profile'"
                    @click="changePage('/member/your-account')"
                    active-class="my-menu-link"
                  >
                    <q-item-section avatar>
                      <is-account />
                    </q-item-section>

                    <q-item-section>Your Profile</q-item-section>
                  </q-item>

                  <q-item
                    @click="doLogout()"
                    clickable
                    v-ripple
                    :active="initialTab === 'signOut'"
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
            </q-card-section>
          </q-card>
        </q-dialog>
      </q-toolbar>
    </q-header>
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
import Swal from 'sweetalert2'
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
  data () {
    return {
      help,
      user: {},
      initialTab: null,
      isLogin: false,
      dialogMobileProfile: false
    }
  },
  mounted () {
    if(Auth.isUserLogin()){
      this.isLogin = true
      this.user = LocalStorage.getItem('autoRepairUser').data.user
    } else {
      this.isLogin = false
    }
  },
  methods: {
    doLogout () {
      if(!Auth.doUserLogout()){
        this.isLogin = false
        this.changePage('/session/login')
      } else {
        Swal.fire({
          title: 'Error',
          text: '-',
        })
      }
    },
    changePage (url) {
      this.$router.push(url)
    }
  },
  watch: {
  '$route.path': {
    handler: function(url) {
      if(url == '/'){
        this.initialTab = 'home'
      }
      else if(url.includes('/workshop')){
        this.initialTab = 'workshop'
      }
      else if(url.includes('/insurance')){
        this.initialTab = 'insurance'
      }
      else if(url.includes('/your-account')){
        this.initialTab = 'profile'
      }
      else if(url.includes('/home-message')){
        this.initialTab = 'messages'
      }
      else if(url.includes('/schedule-list')){
        this.initialTab = 'schedule'
      }
      else if(url.includes('/history-list')){
        this.initialTab = 'history'
      }
      else if(url.includes('/favorite-list')){
        this.initialTab = 'favorite'
      }
      else {
        this.initialTab = ''
      }
      this.dialogMobileProfile = false
    },
      deep: true,
      immediate: true
    }
  }
}
</script>
