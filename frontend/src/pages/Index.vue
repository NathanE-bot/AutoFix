<template>
  <q-page class="landing-page">
    <q-parallax
      class="parallax-lp"
      :height="window.height"
    >
      <template v-slot:media>
        <img src="~assets/images/bg_9.png">
      </template>
      <div>
        <div class="lp-title text-center mb-20">
          <span class="txt-white mr-8">AUTO</span>
          <span class="txt-primary">REPAIR</span>
        </div>
        <div>
          <p class="fs-20 text-white" style="width: 80%; margin: auto; text-align: center;">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
          </p>
        </div>
      </div>
    </q-parallax>
    <div style="height:1000px">
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
      workShop: [],
      test: 'quasar-logo-vertical.svg',
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
    this.fetchDataV2()
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    /* eslint-disable */
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.windowAlter.width = this.window.width + 400
    },
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
