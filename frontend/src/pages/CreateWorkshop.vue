+<template>
  <q-page class="flex flex-center">
      <div class="column">
      <div class="row">
        <q-form action="#" method="post" @submit.prevent="Create">
            <q-card square bordered class="q-pa-lg shadow-1">
            <q-card-section>
                <q-form class="q-gutter-md">
                <q-input square filled clearable v-model="form.name" type="text" label="Name" />
                <q-input square filled clearable v-model="form.address" type="text" label="Address" />
                <q-input square filled clearable v-model="form.description" type="text" label="Description" />
                </q-form>
            </q-card-section>
            <q-card-actions class="q-px-md">
                <q-btn color="primary" type="submit" size="lg" class="full-width" label="Submit" />
            </q-card-actions>
            </q-card>
        </q-form>
      </div>
    </div>
  </q-page>
</template>

<script>
import axios from 'axios'
import Cookies from 'js-cookie'

export default {
  name: 'Create',
  data () {
    return {
      form: {
        name: '',
        address: '',
        description: ''
      }
    }
  },
  methods: {
    Create () {
      /* eslint-disable */
      this.token = Cookies.get('Token')
      axios.post('http://127.0.0.1:8000/api/workshop/create', this.form , { headers: {
        'Authorization': `Bearer ${this.token}`
      }}).then(response => {
          if (response.status === 201) {
              this.$router.push({ path: '/' })
          }else {
              
          }
        console.log(response)
      }).catch(err => {
          console.log(err)
      })
    }
  }
}
</script>