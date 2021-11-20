<template>
  <q-page class="flex flex-center">
    <div>
      <span>Hello World</span>
      <!-- <div v-for="item in workShop" :key="item.id">
        {{item.id}}
        {{item.description}}
      </div> -->
    </div>
  </q-page>
</template>

<script>
import { getAllWorkshop } from '../api/workshopService'
import Cookie from 'js-cookie'

export default ({
  name: 'PageIndex',
  data () {
    return {
      token: '',
      workShop: []
    }
  },
  mounted () {
    this.fetchDataV2()
    // console.log(this.workShop)
  },
  methods: {
    /* eslint-disable */
    // fetchData () {
    //   /* eslint-disable */
    //   // let _this = this
    //   this.token = Cookie.get('Token')
    //   axios.get('http://127.0.0.1:8000/api/workshop', { headers: {
    //     'Authorization': `Bearer ${this.token}`
    //   }}).then(response => {
    //     _this.workShop = response
    //     console.log(_this.workShop)
    //     // console.log(response)
    //   })
    // },
    fetchDataV2(){
      let _this = this
      this.token = Cookie.get('Token')
      getAllWorkshop(this.token)
      .then(response => {
        _this.workShop = response.data.objectReturn
        console.log('response', response.data)
        console.log('workshop', _this.workShop)
      })
    }
  }
})
</script>
