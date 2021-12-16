<template>
  <q-page class="flex flex-center">
      <div class="center_page w-70">
        <q-card class="my-card login-card fw position-relative m-auto" :style="{height: windowAlter.height + 'px'}">
          <q-card-section class="p-35">
            <div class="row">
              <div class="col-md-7 pr-12 l_side">
                <img @click="changePage('/')" class="logo-logReg cursor-pointer" src="~assets/images/logo.png" alt="">
                <img class="car-img" src="~assets/images/background_img/car_bg_1.jpg" alt="">
              </div>
              <div class="col-md-5 pl-12 r_side">
                <h5 class="m-0 fw-semibold">Log In to AutoRepair.</h5>
                <q-form
                  @submit.prevent.stop="doLogin"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <div class="q-gutter-sm">
                    <q-input
                      v-model="form.email"
                      :rules="rules.email_r" lazy-rules
                      type="email"
                      label="Email"
                      borderless
                      class="default-input-1"
                    >
                      <template v-slot:prepend>
                        <q-icon name="email" />
                      </template>
                    </q-input>
                    <div class="relative-position">
                      <q-input
                        v-model="form.password"
                        :rules="rules.password_r" lazy-rules
                        :type="isPwd ? 'password' : 'text'"
                        label="Password"
                        borderless
                        class="default-input-1"
                      >
                        <template v-slot:prepend>
                          <q-icon name="lock" />
                        </template>
                        <template v-slot:append>
                          <q-icon
                            :name="isPwd ? 'visibility_off' : 'visibility'"
                            class="cursor-pointer"
                            @click="isPwd = !isPwd"
                          />
                        </template>
                      </q-input>
                      <div class="forgot_pass_pos">
                        <span class="link_txt slate_grey">Forgot password?</span>
                      </div>
                    </div>
                  </div>
                  <div class="q-gutter-sm">
                    <q-btn
                      class="tf-capitalize"
                      padding="6px 32px"
                      rounded unelevated
                      type="submit"
                      label="Login"
                      color="primary"/>
                    <q-btn
                      class="tf-capitalize q-ml-sm"
                      padding="6px 32px"
                      flat rounded unelevated
                      type="reset"
                      label="Clear"
                      color="primary"
                      />
                  </div>
                  <div class="d-flex a-center q-ml-lg q-mt-lg">
                    <span>Don't have an account?&nbsp;</span>
                    <span @click="changePage('/session/register')" class="link_txt primary_color">Create account</span>
                  </div>
                </q-form>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
  </q-page>
</template>

<script>
/* eslint-disable */
import { loginToWebsite } from '../../api/loginRegisterServices'
import { LocalStorage } from 'quasar'
import Swal from 'sweetalert2'

export default {
  components: {
    Swal,
    LocalStorage
  },
  data () {
    return {
      form: {
        email: '',
        password: ''
      },
      isPwd: true,
      rules: {
        email_r: [
          v => !!v || 'Email Harus Diisi',
          v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Format Email Salah'
        ],
        password_r: [
          v => !!v || 'Password Harus Diisi',
          v => v.length >= 8 || 'Password minimal 8 karakter'
        ]
      },
      window: {
        width: 0,
        height: 0
      },
      windowAlter: {
        width: 0,
        height: 0
      }
    }
  },
  mounted () {
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
      this.windowAlter.height = this.window.height - (this.window.height * 0.2)
    },
    doConsole (a) {
      console.log(a)
    },
    changePage (url) {
      this.$router.push(url)
    },
    clearForm () {
      this.form.email = ''
      this.form.password = ''
    },
    doLogin () {
      loginToWebsite(this.form).then(response => {
        console.log(response)
        if (response.status === 200) {
          LocalStorage.set('autoRepairUser', response)
          // Cookies.set('name', response.data.name)
          // Cookies.set('userId', response.data.id)
          // Cookies.set('userEmail', response.data.email)
          // Cookies.set('Token', response.data.token)
        }
        this.changePage('/')
      }) .catch(function (error) {
          if(error.response.data.error === 'Unauthorised') {
            Swal.fire({
              title: 'Email is not registered',
              text: 'Please try again.',
            })
          }
        })
    }
  }
}
</script>
