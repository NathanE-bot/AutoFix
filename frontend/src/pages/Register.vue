<template>
  <q-page class="flex flex-center">
      <div class="column">
      <div class="row">
        <q-form method="post" @submit.prevent="Register">
            <q-card square bordered class="q-pa-lg shadow-1">
            <q-card-section>
                <q-form class="q-gutter-md">
                <q-input square filled clearable v-model="form.name" type="text" label="Name" />
                <q-input square filled clearable v-model="form.email" type="email" label="Email" />
                <q-input square filled clearable v-model="form.password" type="password" label="Password" />
                <q-input square filled clearable v-model="form.password_confirmation" type="password" label="Password Confirmation" />
                </q-form>
            </q-card-section>
            <q-card-actions class="q-px-md">
                <q-btn color="primary" type="submit" size="lg" class="full-width" label="Register" />
            </q-card-actions>
            <q-card-section class="text-center q-pa-none">
                <p class="text-grey-6">Already have account? <router-link to="/Login">Login!</router-link></p>
            </q-card-section>
            </q-card>
        </q-form>
      </div>
    </div>
  </q-page>
</template>

<script>
import axios from 'axios'
export default ({
  name: 'Register',
  data () {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    Register () {
      axios.post('http://127.0.0.1:8000/api/register', this.form).then(response => {
        console.log(response)
        this.$router.push({ path: '/' })
      }).catch(err => console.log(err))
    }
  }
})
</script>
