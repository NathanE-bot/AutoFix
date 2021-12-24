<template>
  <q-page class="flex flex-center">
      <div class="w-70">
        <q-card class="my-card register-card">
          <q-card-section class="p-35">
            <div class="d-flex a-center j-sp-between">
              <h5 class="m-0 fw-blackbold fs-35">Welcome, Create your account here.</h5>
              <img class="logo-logReg pos-logReg-right" src="~assets/images/logo.png" alt="">
            </div>
            <div class="row">
              <div class="col-md-6 pr-12 l_side">
                <q-form
                  @submit.prevent="doRegister"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <q-scroll-area
                    :thumb-style="thumbStyle"
                    :bar-style="barStyle"
                    class="default-left-scrollbar"
                    style="height: 335px"
                  >
                    <div class="row q-gutter-y-sm" style="direction: ltr">
                      <q-input
                        v-model="form.fullName"
                        :rules="rules.fullName_r" lazy-rules
                        type="text"
                        label="Nama Lengkap"
                        borderless
                        class="col-md-12 default-input-1"
                      >
                        <template v-slot:prepend>
                          <q-icon name="person" />
                        </template>
                      </q-input>
                      <q-input
                        v-model="form.email"
                        :rules="rules.email_r" lazy-rules
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
                        :rules="rules.password_r" lazy-rules
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
                        :rules="rules.password_confirmation_r" lazy-rules
                        :type="isPwd ? 'password' : 'text'"
                        label="Konfirmasi Password"
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
                        v-model="form.DoB"
                        :rules="rules.DoB_r" lazy-rules
                        type="text"
                        label="Tanggal Lahir"
                        borderless
                        class="col-md-6 pr-6 default-input-1"
                      >
                        <template v-slot:append>
                          <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                              <q-date v-model="tempDoB">
                                <div class="row items-center justify-end">
                                  <q-btn @click="form.DoB = tempDoB" v-close-popup label="Ok" color="primary" flat />
                                </div>
                              </q-date>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                      <q-input
                        v-model="form.phoneNumber"
                        :rules="rules.phoneNumber_r" lazy-rules
                        label="Nomor Telepon"
                        borderless
                        class="col-md-6 pl-6 default-input-1">
                          <template v-slot:prepend>
                            <q-icon name="call" />
                          </template>
                      </q-input>
                      <q-input
                        v-model="form.address"
                        :rules="rules.address_r" lazy-rules
                        borderless label="Alamat"
                        type="textarea"
                        class="col-md-12 default-input-1 fix-txt-field"
                      />
                    </div>
                  </q-scroll-area>
                  <div class="q-gutter-sm">
                    <q-btn
                      class="tf-capitalize"
                      padding="6px 32px"
                      rounded unelevated
                      type="submit"
                      label="Register"
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
                    <span>Already have an account?&nbsp;</span>
                    <span @click="changePage('/session/login')" class="link_txt primary_color">Log in</span>
                  </div>
                </q-form>
              </div>
              <div class="col-md-6 pl-12 r_side">
                <img class="car-img" src="~assets/images/background_img/car_bg_1.jpg" alt="">
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

export default ({
  data () {
    return {
      // scrollbar styles
      thumbStyle: {
        right: '4px',
        borderRadius: '10px',
        backgroundColor: '#21a17b',
        width: '10px',
        opacity: 0.75
      },
      barStyle: {
        right: '2px',
        borderRadius: '10px',
        backgroundColor: '#21a17b',
        width: '10px',
        opacity: 0.2
      },
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
      isPwd: true,
      rules: {
        fullName_r: [
          v => !!v || 'Nama harus diisi'
        ],
        email_r: [
          v => !!v || 'Email harus diisi',
          v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Format email salah'
        ],
        password_r: [
          v => !!v || 'Password harus diisi',
          v => v.length >= 8 || 'Password minimal 8 karakter'
        ],
        password_confirmation_r: [
          v => !!v || 'Password harus diisi',
          v => !!v != this.form.password || 'Password belum sama'
        ],
        DoB_r: [
          v => !!v || 'Tanggal lahir harus diisi'
        ],
        phoneNumber_r: [
          v => !!v || 'Nomor telepon harus diisi'
        ],
        address_r: [
          v => !!v || 'Alamat harus diisi'
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
      registerToWebsite(this.form).then(response => {
        if (response.status === 200) {
          let temp = []
          temp = response.data
          console.log(temp)
        }
        // this.changePage('/')
      }) .catch(function (error) {
        if(error.response.data.error === 'Unauthorised') {
          Swal.fire({
            title: 'Testing'
          })
        }
      })
    }
  }
})
</script>
