<template>
  <q-page class="landing-page">
    <q-parallax
      class="parallax-lp"
      :height="window.height"
    >
      <template v-slot:media>
        <img src="~assets/images/bg_9.png">
      </template>
      <div :style="{height: window.height + 'px'}">
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
        <div class="m-auto w-40 mt-20-i h-100">
          <q-input
            v-model="search"
            rounded outlined
            placeholder="Find the nearest workshop to you here..."
            class="lp-search-input"
          >
            <template v-slot:append>
              <q-btn
                class="lp-search-btn"
                color="primary"
                label="Search"
                rounded outlined unelevated />
            </template>
          </q-input>
          <div class="d-flex flex-dir-col j-sp-between h-55">
            <div class="mt-20">
              <img class="responsive-img" src="~assets/images/car_stock_img.png" alt="">
            </div>
            <div class="d-flex a-center j-center">
              <div class="d-flex a-center mr-30">
                <q-btn class="relative-position mr-16" unelevated round color="secondary">
                  <img class="responsive-img iconify round_btn_layout" src="~assets/iconify/car_mechanic.png" alt="">
                </q-btn>
                <span class="text-white">Service 01</span>
              </div>
              <div class="d-flex a-center mr-30">
                <q-btn class="relative-position mr-16" unelevated round color="secondary">
                  <img class="responsive-img iconify round_btn_layout_cs" src="~assets/iconify/customer_service.png" alt="">
                </q-btn>
                <span class="text-white">Service 01</span>
              </div>
              <div class="d-flex a-center">
                <q-btn class="relative-position mr-16" unelevated round color="secondary">
                  <img class="responsive-img iconify round_btn_layout_gear" src="~assets/iconify/rotating_gear.png" alt="">
                </q-btn>
                <span class="text-white">Service 01</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </q-parallax>
    <div class="white-bg bottom-section black-1" style="height:1000px">
      <div class="text-center">
        <h4 class="m-0 primary_color">Recommendation For You</h4>
        <span class="fs-16">Get the best service experience from us</span>
      </div>
      <div class="py-30">
        <swiper
          :slidesPerView="3"
          :spaceBetween="30"
          :navigation="true"
          :pagination='{
            "clickable": true
          }'
          class="mySwiper"
        >
          <swiper-slide>
            <q-card class="m-5">
              <img src="https://cdn.quasar.dev/img/mountains.jpg">
              <q-card-section>
                <div class="text-h6 primary_color">Bengkel ABC</div>
                <div class="text-subtitle2">
                  Business Park Kebon Jeruk Blok G5, Jl. Meruya Ilir Raya No. 88, RT.1/RW.5, Meruya Utara, Kec. Kembangan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11510
                </div>
                <div class="text-subtitle2 my-16">
                  <span>Operasional :&nbsp;</span>
                  <span class="primary_color">9 AM - 18 PM</span>
                </div>
                <div class="d-flex a-center j-sp-between">
                  <div class="d-flex a-center">
                    <i class="fas fa-star rating_yellow mr-5 mb-2"></i>
                    <span>4.8</span>
                  </div>
                  <div class="d-flex a-center">
                    <i class="fas fa-mobile-alt mr-8"></i>
                    <span>081923568765</span>
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </swiper-slide>
          <swiper-slide>Slide 2</swiper-slide>
          <swiper-slide>Slide 3</swiper-slide>
          <swiper-slide>Slide 4</swiper-slide>
          <swiper-slide>Slide 5</swiper-slide>
          <swiper-slide>Slide 6</swiper-slide>
          <swiper-slide>Slide 7</swiper-slide>
          <swiper-slide>Slide 8</swiper-slide>
          <swiper-slide>Slide 9</swiper-slide>
        </swiper>
      </div>
    </div>
  </q-page>
</template>

<script>
/* eslint-disable */
import { Swiper, SwiperSlide } from 'swiper/vue'
import SwiperCore, {
  Navigation
} from 'swiper';
import { getAllWorkshop } from '../api/workshopService'
import Cookie from 'js-cookie'

SwiperCore.use([Navigation]);

export default ({
  name: 'PageIndex',
  components: {
    Swiper,
    SwiperSlide
  },
  setup() {
    const onSwiper = (swiper) => {
      console.log(swiper);
    };
    const onSlideChange = () => {
      console.log('slide change');
    };
    return {
      onSwiper,
      onSlideChange,
    };
  },
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
      },
      search: ''
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
