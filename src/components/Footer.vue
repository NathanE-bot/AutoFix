<template>
  <q-footer class="show-m autorepair-footer" elevated>
    <q-toolbar>
      <q-tabs
          v-model="initialTab"
          dense
          class="m-auto"
          active-color="primary"
          indicator-color="primary"
          align="justify"
        >
          <q-tab @click="changePage('/')" name="home" label="Home" icon="fas fa-home"  />
          <q-tab @click="changePage('/workshop')" name="workshop" label="workshop" icon="fas fa-car-alt" />
          <div class="relative-position m-dropdown-button">
            <!-- <q-tab class="insurance-tab" name="insurance" icon="fas fa-car-crash" /> -->
            <q-tab name="insurance" label="Insurance" icon="fas fa-car-crash" />
            <q-btn-dropdown
              :color="initialTab == 'insurance' ? 'primary' : ''"
              auto-close flat :ripple="false" :menu-offset="[25, 0]"
              transition-show="jump-down" transition-hide="jump-up"
              class="tf-capitalize fs-16 dropdown-btn-tab"
              content-class="dropdown-tab-inverted text-white"
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
    </q-toolbar>
  </q-footer>
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