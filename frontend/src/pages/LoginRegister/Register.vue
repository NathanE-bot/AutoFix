<template>
  <q-page class="flex flex-center">
      <div class="center_page w-70">
        <q-card class="my-card register-card fw" :style="{height: windowAlter.height + 'px'}">
          <q-card-section class="p-35">
            <div class="row">
              <div class="col-md-6 pr-12 l_side">
                <h5 class="m-0 fw-semibold">Create Account AutoRepair.</h5>
                <q-form
                  @submit.prevent="doRegister"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <div class="row q-gutter-y-sm">
                    <q-input
                      v-model="form.name"
                      :rules="rules.name_r" lazy-rules
                      type="text"
                      label="Nama"
                      borderless
                      class="col-md-6 pr-6 default-input-1"
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
                      class="col-md-6 pl-6 default-input-1"
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
                  </div>
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
                <img @click="changePage('/')" class="logo-logReg cursor-pointer" src="~assets/images/logo.png" alt="">
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
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      isPwd: true,
      rules: {
        name_r: [
          v => !!v || 'Nama Harus Diisi'
        ],
        email_r: [
          v => !!v || 'Email Harus Diisi',
          v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Format Email Salah'
        ],
        password_r: [
          v => !!v || 'Password Harus Diisi',
          v => v.length >= 8 || 'Password minimal 8 karakter'
        ],
        password_confirmation_r: [
          v => !!v || 'Password Harus Diisi',
          v => !!v != this.form.password || 'Password belum sama'
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
    clearForm () {
      this.form.name = ''
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
      this.$router.push(url)
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
