<template>
  <q-page class="flex flex-center">
      <div class="column">
      <div class="row">
        <q-form action="#" method="post" @submit.prevent="Login">
            <q-card square bordered class="q-pa-lg shadow-1">
            <q-card-section>
                <q-form class="q-gutter-md">
                <q-input square filled clearable v-model="form.email" type="text" label="Email" />
                <q-input square filled clearable v-model="form.password" type="password" label="Password" />
                </q-form>
            </q-card-section>
            <q-card-actions class="q-px-md">
                <q-btn color="primary" type="submit" size="lg" class="full-width" label="Login" />
            </q-card-actions>
            <q-card-section class="text-center q-pa-none">
                <p class="text-grey-6">Don't have account? <router-link to="/Register">Register!</router-link></p>
            </q-card-section>
            </q-card>
        </q-form>
      </div>
    </div>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'
import Cookies from 'js-cookie'

export default defineComponent({
  name: 'Login',
  data () {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
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
})
</script>
