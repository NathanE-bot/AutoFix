<template>
  <q-page class="flex flex-center">
      <div class="w-70">
        <q-card class="my-card login-card fw position-relative m-auto">
          <q-card-section class="p-35 flex flex-center">
            <div class="row d-flex a-center">
              <div class="col-md-7 pr-12 l_side">
                <img class="logo-logReg pos-logReg-left responsive_img fit-content" width="150" src="~assets/images/logo.png" alt="">
                <img class="car-img responsive_img fit-content" style="margin-top: 56px;" src="~assets/images/background_img/car_bg_1.jpg" alt="">
              </div>
              <div class="col-md-5 pl-12 r_side">
                <div class="d-flex a-center j-sp-between">
                  <h3 class="m-0 fw-blackbold fs-45" style="margin-bottom: 7%">Welcome Back!</h3>
                  <div class="d-flex flex-dir-col a-center pos-back-btn-right">
                    <q-btn
                      @click="backToLandingPage()"
                      round flat
                      size="lg"
                    >
                      <i class="fas fa-chevron-left fs-30"></i>
                    </q-btn>
                    <!-- <span>Back</span> -->
                  </div>
                </div>
                <q-form
                  @submit.prevent.stop="doLogin"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <div class="q-gutter-sm">
                    <q-input
                      v-model="form.email"
                      :rules="rules.email_r" lazy-rules="ondemand"
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
                        :rules="rules.password_r" lazy-rules="ondemand"
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
                      <div class="forgot_pass_pos" @click="changePage('/session/forgotpassword')">
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
                      color="primary"
                    />
                    <q-btn
                      @click="changePage('/session/register')"
                      class="tf-capitalize q-ml-sm"
                      padding="6px 32px"
                      rounded outline
                      label="Create Account"
                      color="primary"
                    />
                  </div>
                  <!-- <div class="d-flex a-center q-ml-lg q-mt-lg">
                    <span>Don't have an account?&nbsp;</span>
                    <span @click="changePage('/session/register')" class="link_txt primary_color">Create account</span>
                  </div> -->
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
          v => !!v || 'Email is required',
          v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Wrong email format'
        ],
        password_r: [
          v => !!v || 'Password is required'
        ]
      },
      window: {
        width: 0,
        height: 0,
        heightAltered: 0
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
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (18/100))
    },
    doConsole (a) {
      console.log(a)
    },
    backToLandingPage () {
      this.$router.push('/')
    },
    changePage (url) {
      if(url === undefined) {
        this.$router.go(-1)
      } else {
        this.$router.push(url)
      }
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
        }
        let user = LocalStorage.getItem('autoRepairUser').data.user
        if(user.role == 1){
          this.changePage('/')
        } else if (user.role == 2) {
          this.changePage('/admin/workshop/home')
        } else {
          this.changePage('/admin/insurance/home')
        }
      }) .catch(function (error) {
          if(error.response.status === 401) {
            Swal.fire({
              title: 'Error',
              text: error.response.data.error
            })
          }
        })
    }
  }
}
</script>
