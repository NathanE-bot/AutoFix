<template>
  <q-page class="flex flex-center">
      <div class="w-70 m-w-100 m-minh-inherit flex flex-center">
        <q-card class="my-card register-card m-auto m-minh-inherit">
          <q-card-section class="p-35 hide-m">
            <div class="d-flex a-center j-sp-between">
              <h5 class="m-0 fw-blackbold fs-35">Welcome, Create your account here.</h5>
              <img class="logo-logReg pos-logReg-right responsive_img fit-content" width="150" src="~assets/images/logo.png" alt="">
            </div>
            <div class="row">
              <div class="col-md-6 pr-12 l_side">
                <q-form
                  @submit.prevent="doRegister"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <q-scroll-area
                    :thumb-style="help.data().thumbStyle"
                    :bar-style="help.data().barStyle"
                    class="default-left-scrollbar"
                    style="height: 335px"
                  >
                    <div class="row q-gutter-y-sm" style="direction: ltr">
                      <q-input
                        v-model="form.fullName"
                        :rules="rules.fullName_r" lazy-rules="ondemand"
                        type="text"
                        label="Full Name"
                        borderless
                        class="col-md-12 default-input-1"
                      >
                        <template v-slot:prepend>
                          <q-icon name="person" />
                        </template>
                      </q-input>
                      <q-input
                        v-model="form.email"
                        :rules="rules.email_r" lazy-rules="ondemand"
                        type="email"
                        label="Email"
                        borderless
                        class="col-md-12 default-input-1"
                      >
                        <template v-slot:prepend>
                          <q-icon name="email" />
                        </template>
                      </q-input>
                      <q-input
                        v-model="form.password"
                        :rules="rules.password_r" lazy-rules="ondemand"
                        :type="isPwd ? 'password' : 'text'"
                        label="Password"
                        borderless
                        class="col-md-12 default-input-1"
                      >
                        <template v-slot:prepend>
                          <q-icon name="lock" />
                        </template>
                      </q-input>
                      <q-input
                        v-model="form.password_confirmation"
                        :rules="rules.password_confirmation_r" lazy-rules="ondemand"
                        :type="isPwd ? 'password' : 'text'"
                        label="Confirmation Password"
                        borderless
                        class="col-md-12 default-input-1"
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
                      <q-input
                        v-model="tempDoBP"
                        :rules="rules.DoB_r" lazy-rules="ondemand"
                        type="text"
                        label="Date of Birth"
                        borderless readonly
                        class="col-md-6 pr-6 default-input-1-dob"
                      >
                        <template v-slot:append>
                          <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                              <q-date v-model="tempDoB" :options="(date) => date <= help.formatToday(help.data().dmy_3)">
                                <div class="row items-center justify-end">
                                  <q-btn @click="form.DoB = tempDoB; tempDoBP = tempDoB" v-close-popup label="Ok" color="primary" flat />
                                </div>
                              </q-date>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                      <q-input
                        v-model="form.phoneNumber"
                        :rules="rules.phoneNumber_r" lazy-rules="ondemand"
                        label="Phone Number"
                        borderless
                        class="col-md-6 pl-6 default-input-1">
                          <template v-slot:prepend>
                            <q-icon name="call" />
                          </template>
                      </q-input>
                      <q-input
                        v-model="form.address"
                        :rules="rules.address_r" lazy-rules="ondemand"
                        borderless label="Address"
                        type="textarea"
                        class="col-md-12 default-input-1 fix-txt-field"
                      />
                    </div>
                  </q-scroll-area>
                  <div class="q-gutter-sm">
                    <q-btn
                      :loading="loader"
                      class="tf-capitalize"
                      padding="6px 32px"
                      rounded unelevated
                      type="submit"
                      label="Register"
                      color="primary"/>
                    <q-btn
                      :loading="loader"
                      @click="changePage('/session/login')"
                      class="tf-capitalize q-ml-sm"
                      padding="6px 32px"
                      rounded outline
                      label="Login"
                      color="primary"
                      />
                  </div>
                  <!-- <div class="d-flex a-center q-ml-lg q-mt-lg">
                    <span>Already have an account?&nbsp;</span>
                    <span @click="changePage('/session/login')" class="link_txt primary_color">Log in</span>
                  </div> -->
                </q-form>
              </div>
              <div class="col-md-6 pl-12 r_side">
                <img class="car-img responsive_img fit-content" src="~assets/images/background_img/car_bg_1.jpg" alt="">
              </div>
            </div>
          </q-card-section>
          <q-card-section class="flex flex-dir-col j-sp-between show-m m-minh-inherit">
            <div class="d-flex a-center j-sp-between">
              <img class="responsive_img fit-content" width="120" src="~assets/images/logo.png" alt="">
              <q-btn
                @click="backToLandingPage()"
                round flat
                size="lg"
              >
                <i class="fas fa-chevron-left fs-30"></i>
              </q-btn>
            </div>
            <h5 class="my-10 fw-blackbold text-align-center">Welcome, Create your account here.</h5>
            <div class="row">
              <div class="col-xs-12">
                <img class="car-img responsive_img fit-content" src="~assets/images/background_img/car_bg_1.jpg" alt="">
              </div>
              <div class="col-xs-12">
                <q-form
                  @submit.prevent="doRegister"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <div class="row q-gutter-y-sm" style="direction: ltr">
                    <q-input
                      v-model="form.fullName"
                      :rules="rules.fullName_r" lazy-rules="ondemand"
                      type="text"
                      label="Full Name"
                      borderless
                      class="col-xs-12 default-input-1"
                    >
                      <template v-slot:prepend>
                        <q-icon name="person" />
                      </template>
                    </q-input>
                    <q-input
                      v-model="form.email"
                      :rules="rules.email_r" lazy-rules="ondemand"
                      type="email"
                      label="Email"
                      borderless
                      class="col-xs-12 default-input-1"
                    >
                      <template v-slot:prepend>
                        <q-icon name="email" />
                      </template>
                    </q-input>
                    <q-input
                      v-model="form.password"
                      :rules="rules.password_r" lazy-rules="ondemand"
                      :type="isPwd ? 'password' : 'text'"
                      label="Password"
                      borderless
                      class="col-xs-12 default-input-1"
                    >
                      <template v-slot:prepend>
                        <q-icon name="lock" />
                      </template>
                    </q-input>
                    <q-input
                      v-model="form.password_confirmation"
                      :rules="rules.password_confirmation_r" lazy-rules="ondemand"
                      :type="isPwd ? 'password' : 'text'"
                      label="Confirmation Password"
                      borderless
                      class="col-xs-12 default-input-1"
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
                    <q-input
                      v-model="tempDoBP"
                      :rules="rules.DoB_r" lazy-rules="ondemand"
                      type="text"
                      label="Date of Birth"
                      borderless readonly
                      class="col-xs-12 default-input-1-dob"
                    >
                      <template v-slot:append>
                        <q-icon name="event" class="cursor-pointer">
                          <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                            <q-date v-model="tempDoB" :options="(date) => date <= help.formatToday(help.data().dmy_3)">
                              <div class="row items-center justify-end">
                                <q-btn @click="form.DoB = tempDoB; tempDoBP = tempDoB" v-close-popup label="Ok" color="primary" flat />
                              </div>
                            </q-date>
                          </q-popup-proxy>
                        </q-icon>
                      </template>
                    </q-input>
                    <q-input
                      v-model="form.phoneNumber"
                      :rules="rules.phoneNumber_r" lazy-rules="ondemand"
                      label="Phone Number"
                      borderless
                      class="col-xs-12 default-input-1">
                        <template v-slot:prepend>
                          <q-icon name="call" />
                        </template>
                    </q-input>
                    <q-input
                      v-model="form.address"
                      :rules="rules.address_r" lazy-rules="ondemand"
                      borderless label="Address"
                      type="textarea"
                      class="col-xs-12 default-input-1 fix-txt-field"
                    />
                  </div>
                  <div>
                    <q-btn
                      :loading="loader"
                      class="tf-capitalize fw mb-10"
                      padding="12px 12px"
                      rounded unelevated
                      type="submit"
                      label="Register"
                      color="primary"/>
                    <q-btn
                      :loading="loader"
                      @click="changePage('/session/login')"
                      class="tf-capitalize fw"
                      padding="12px 12px"
                      rounded outline
                      label="Login"
                      color="primary"
                      />
                  </div>
                  <!-- <div class="d-flex a-center q-ml-lg q-mt-lg">
                    <span>Already have an account?&nbsp;</span>
                    <span @click="changePage('/session/login')" class="link_txt primary_color">Log in</span>
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
import { registerToWebsite } from '../../api/loginRegisterServices'
import help from '../../js/help'
import Swal from 'sweetalert2'

export default ({
  data () {
    return {
      // scrollbar styles
      help,
      loader: false,
      form: {
        fullName: '',
        email: '',
        password: '',
        password_confirmation: '',
        DoB: '',
        phoneNumber: '',
        address: ''
      },
      tempDoB: null,
      tempDoBP: null,
      isPwd: true,
      rules: {
        fullName_r: [
          v => !!v || 'Name is required'
        ],
        email_r: [
          v => !!v || 'Email is required',
          v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Wrong Email format'
        ],
        password_r: [
          v => !!v || 'Password is required',
          v => v.length >= 8 || 'Password min 8 characters'
        ],
        password_confirmation_r: [
          v => !!v || 'Password confirmation is required',
          v => v === this.form.password || 'Password is not the same'
        ],
        DoB_r: [
          v => !!v || 'Date of Birth is required'
        ],
        phoneNumber_r: [
          v => !!v || 'Phone number is required'
        ],
        address_r: [
          v => !!v || 'Address is required'
        ],
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
    backToLandingPage () {
      this.$router.push('/')
    },
    clearForm () {
      this.form.fullName = ''
      this.form.email = ''
      this.form.password = ''
      this.form.password_confirmation = ''
    },
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.windowAlter.height = this.window.height - (this.window.height * 0.2)
    },
    changePage (url) {
      if(url === undefined) {
        this.$router.go(-1)
      } else {
        this.$router.push(url)
      }
    },
    doRegister () {
      let _this = this
      _this.loader = true
      console.log(_this.form.DoB)
      _this.form.DoB = help.defaultFormat(_this.form.DoB, help.data().dmy_5)
      registerToWebsite(this.form).then(response => {
        // console.log(response)
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.data.message,
          customClass: {
              confirmButton: 'br-25px-i py-5-i px-20-i'
          }
        }) .then((result) => {
          if(result.isConfirmed){
            _this.changePage('/session/otp/' + response.data.encryptUserId)
            _this.loader = false
          }
        })
      }) .catch(function (error) {
        _this.loader = false
        if(error.response.data.error === 'Unauthorised') {
          Swal.fire({
            title: 'Error',
            customClass: {
              confirmButton: 'br-25px-i py-5-i px-20-i'
            }
          })
        }
      })
    }
  }
})
</script>
