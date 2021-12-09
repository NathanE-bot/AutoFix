<template>
  <q-page class="flex flex-center login_section">
      <div class="center_page w-70">
        <q-card class="my-card login-card fw">
          <q-card-section class="p-35">
            <div class="row">
              <div class="col-md-6 pr-12 l_side">
                <div class="d-flex a-center fs-40">
                  <span class="black_2 mr-5">AUTO</span>
                  <span class="txt-primary">REPAIR</span>
                </div>
                <div class="workshop-bg workshop-bg-register"></div>
              </div>
              <div class="col-md-6 pl-12 r_side">
                <h5 class="m-0 fw-semibold">Create Account AutoRepair.</h5>
                <q-form
                  @submit.prevent="Login"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <div class="row q-gutter-y-sm">
                    <q-input
                      ref="nameRef"
                      v-model="form.name"
                      :rules="rules.name_r" lazy-rules
                      type="text"
                      label="Nama"
                      filled
                      class="col-md-6 pr-6"
                    >
                      <template v-slot:prepend>
                        <q-icon name="person" />
                      </template>
                    </q-input>
                    <q-input
                      ref="emailRef"
                      v-model="form.email"
                      :rules="rules.email_r" lazy-rules
                      type="email"
                      filled
                      label="Email"
                      class="col-md-6 pl-6"
                    >
                      <template v-slot:prepend>
                        <q-icon name="email" />
                      </template>
                    </q-input>
                    <q-input
                      ref="passRef"
                      v-model="form.password"
                      :rules="rules.password_r" lazy-rules
                      :type="isPwd ? 'password' : 'text'"
                      filled
                      label="Password"
                      class="col-md-12"
                    >
                      <template v-slot:prepend>
                        <q-icon name="lock" />
                      </template>
                    </q-input>
                    <q-input
                      ref="passConfRef"
                      v-model="form.password_confirmation"
                      :rules="rules.password_confirmation_r" lazy-rules
                      :type="isPwd ? 'password' : 'text'"
                      filled
                      label="Konfirmasi Password"
                      class="col-md-12"
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
                    <span @click="changePage('/login')" class="link_txt primary_color">Log in</span>
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
/* eslint-disable-no-undef */
/* eslint-disable */
import axios from 'axios'
import { ref } from 'vue'

export default ({
  data () {
    return {
      ref: {
        nameRef: ref(null),
        emailRef: ref(null),
        passRef: ref(null),
        passConfRef: ref(null)
      },
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
          v => !!v === this.form.password || 'Password belum sama'
        ]
      }
    }
  },
  methods: {
    changePage (url) {
      this.$router.push(url)
    },
    // validateForm () {
    //   this.nameRef.value.validate()
    //   this.emailRef.value.validate()
    //   this.passRef.value.validate()
    //   this.passConfRef.value.validate()
    // },
    Register () {
      // this.validateForm()
      axios.post('http://127.0.0.1:8000/api/register', this.form).then(response => {
        console.log(response)
        // this.$router.push({ path: '/' })
      }).catch(err => console.log(err))
    }
  }
})
</script>
