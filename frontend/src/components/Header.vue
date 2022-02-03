<template>
    <q-header class="autorepair-header">
      <q-toolbar>
        <div class="relative-box">
          <img class="logo-img fixed-top-left fit-content" src="../assets/images/logo.png" alt="">
        </div>
        <q-tabs
          v-model="initialTab"
          dense
          class="m-auto"
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
        <div class="relative-position">
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
                    :offset="[25, 15]"
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
      </q-toolbar>
    </q-header>
</template>

<script>
/* eslint-disable */
import help from '../js/help'
import Auth from '../js/AuthValidation'
import Swal from 'sweetalert2'
import { LocalStorage } from 'quasar'

export default {
  data () {
    return {
      help,
      user: {},
      initialTab: null,
      isLogin: false
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
      else {
        this.initialTab = ''
      }
    },
      deep: true,
      immediate: true
    }
  }
}
</script>
