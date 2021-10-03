<template>
  <q-page class="flex flex-center">
    <q-table></q-table>
  </q-page>
</template>

<script>
import axios from 'axios'
import { defineComponent } from 'vue'
import Cookie from 'js-cookie'

export default defineComponent({
  name: 'PageIndex',
  data () {
    return {
      token: ''
    }
  },
  mounted () {
    this.fetchData()
  },
  methods: {
    fetchData () {
      /* eslint-disable */
      this.token = Cookie.get('Token')
      axios.get('http://127.0.0.1:8000/api/workshop', { headers: {
        'Authorization': `Bearer ${this.token}`
      }}).then(response => {
        console.log(response)
      })
    }
  }
})
</script>
