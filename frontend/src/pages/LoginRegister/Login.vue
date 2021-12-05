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
                <div class="workshop-bg"></div>
              </div>
              <div class="col-md-6 pl-12 r_side">
                <h5 class="m-0 fw-semibold">Log In to AutoRepair.</h5>
                <q-form
                  @submit.prevent="Login"
                  @reset="clearForm"
                  class="q-gutter-md mt-10"
                >
                  <div class="q-gutter-sm">
                    <q-input
                      v-model="form.email"
                      :rules="rules.email_r" lazy-rules
                      type="email"
                      filled
                      label="Email"
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
                        filled
                        label="Password">
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
                      label="Reset"
                      color="primary"
                      />
                    <q-btn
                      @click="changePage('/register')"
                      class="tf-capitalize q-ml-sm"
                      rounded outline unelevated
                      label="Create Account"
                      color="primary"
                    />
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
import axios from 'axios'
import Cookies from 'js-cookie'

export default {
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
      }
    }
  },
  methods: {
    doConsole (a) {
      console.log(a)
    },
    changePage (url) {
      this.$router.push(url)
      console.log(this.$router)
    },
    clearForm () {
      this.form.email = ''
      this.form.password = ''
    },
    Login () {
      axios.post('http://127.0.0.1:8000/api/login', this.form).then(response => {
        console.log(response)
        if (response.status === 200) {
          Cookies.set('name', response.data.name)
          Cookies.set('userId', response.data.id)
          Cookies.set('userEmail', response.data.email)
          Cookies.set('Token', response.data.token)
        }
        this.$router.push({ path: '/' })
      }).catch(err => console.log(err))
    }
  }
}
</script>
