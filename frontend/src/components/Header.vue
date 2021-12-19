<template>
    <q-header class="autorepair-header">
      <q-toolbar>
        <!-- <q-btn
          v-if="propIsDisabled"
          @click="toggleLeftDrawer"
          flat dense round
          icon="menu"
          aria-label="Menu"
        /> -->
        <div class="relative-box">
          <img class="logo-img fixed-top-left" src="../assets/images/logo.png" alt="">
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
          <q-tab name="workshop" label="Workshop" />
          <q-tab name="insurance" label="Insurance" />
          <q-tab name="aboutus" label="About Us" />
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
              <q-btn
                round unelevated
                color="primary"
                size="lg"
              >
                <q-avatar size="60px">
                  <img src="https://cdn.quasar.dev/img/avatar2.jpg">
                </q-avatar>
                <q-menu>
                  <q-list style="min-width: 100px">
                    <q-item
                      @click="changePage('/youraccount')"
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
      </q-toolbar>
    </q-header>
</template>

<script>
/* eslint-disable */
import Auth from '../js/AuthValidation'
import Swal from 'sweetalert2'

export default {
    data () {
      return {
        initialTab: 'home',
        isLogin: false
      }
    },
    created () {
      if(Auth.isUserLogin()){
        this.isLogin = true
      } else {
        this.isLogin = false
      }
    },
    methods: {
      doLogout () {
        if(Auth.doUserLogout()){
          this.isLogin = false
          this.changePage('/session/login')
        } else {
          Swal.fire({
            title: 'Apani error',
            text: 'Kok kamu ngoding bodoh.',
          })
        }
      },
      changePage (url) {
        this.$router.push(url)
      }
    }
}
</script>
