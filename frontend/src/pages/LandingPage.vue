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
            @keyup.enter="doSearchWorkshop()"
            v-model="search"
            rounded outlined
            placeholder="Find the nearest workshop to you here..."
            class="lp-search-input"
          >
            <template v-slot:append>
              <q-btn
                @click="doSearchWorkshop()"
                class="lp-search-btn"
                color="primary"
                type="search"
                label="Search"
                rounded outlined unelevated />
            </template>
          </q-input>
          <div class="d-flex flex-dir-col j-sp-between h-55">
            <div class="mt-20">
              <img class="responsive-img" src="~assets/images/car_stock_img.png" alt="">
            </div>
            <!-- <h4 class="m-auto txt-white cursor-pointer" @click="test()">About Us</h4> -->
            <!-- <div class="d-flex a-center j-center">
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
            </div> -->
          </div>
        </div>
      </div>
    </q-parallax>
    <div class="white-bg bottom-section black-1">
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
          class="mySwiper lp-swiper"
        >
          <swiper-slide v-for="(item) in workshopRecommendation" :key="item.id" @click="changePage('/workshop/detail/' + item.id)">
            <q-card class="my-card cursor-pointer">
              <img src="https://cdn.quasar.dev/img/mountains.jpg">
              <q-card-section>
                <div class="text-h6 primary_color mb-8">{{ item.workshopName }}</div>
                <div class="text-subtitle2 w-85">
                  {{ item.workshopAddress }}
                </div>
                <div class="text-subtitle2 my-16">
                  <span>Operasional :&nbsp;</span>
                  <span class="primary_color">
                    {{help.formatTime(item.operationalOpenHour, help.data().time_1)}} - {{help.formatTime(item.operationalCloseHour, help.data().time_1)}}
                  </span>
                </div>
                <div class="d-flex a-center j-sp-between">
                  <div class="d-flex a-center">
                    <i class="fas fa-star rating_yellow mr-5 mb-2"></i>
                    <span>{{ item.rating }}</span>
                  </div>
                  <div class="d-flex a-center">
                    <i class="fas fa-mobile-alt mr-8"></i>
                    <span>{{ item.workshopPhoneNumber }}</span>
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </swiper-slide>
        </swiper>
      </div>
      <div class="mt-50" id="about-us">
        <div class="text-center">
          <h4 class="m-0 primary_color">How to Use Our Website</h4>
          <span class="fs-16">Get convenience with our website</span>
        </div>
        <q-video class="mt-40-i w-80 m-auto br-10px"
            :ratio="16/6"
            src="https://www.youtube.com/embed/veKsxin7iRg"
          />
      </div>
      <div class="mt-80">
        <div class="text-center">
          <h4 class="m-0 primary_color">Builder Of Our Company</h4>
          <span class="fs-16">Get to know more of the developers</span>
        </div>
        <div class="mt-40 d-flex a-center j-sp-evenly">
          <q-card class="my-card br-10px no-shadow" v-for="n in 3" :key="n">
            <q-card-section horizontal>
              <img class="responsive-img dev_pic"
                src="~assets/images/preset/person_1.png"
              />
              <div class="p-24 pr-36-i card_bg_black_2 text-white d-flex flex-dir-col a-start bg_img_cog_b">
                <span class="fs-20">Kenny Ongko</span>
                <span class="primary_color mb-14">Founder Auto Repair</span>
                <span class="fs-12">Social Media</span>
                <div class="mt-10 d-flex a-center">
                  <div class="sosmed-box mr-16">
                    <i class="fab fa-instagram"></i>
                  </div>
                  <div class="sosmed-box mr-16">
                    <i class="fab fa-facebook-f"></i>
                  </div>
                  <div class="sosmed-box">
                    <i class="fab fa-twitter"></i>
                  </div>
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </div>
      <div class="mt-80 btm-lp">
        <div class="text-center">
          <h4 class="m-0 primary_color">For More Information</h4>
          <span class="fs-16">Reach out to us.</span>
        </div>
        <div class="sosmed_section mt-30">
          <div class="d-flex a-center mr-32">
            <div class="sosmed-box-lp mr-14">
              <i class="fab fa-instagram"></i>
            </div>
            <span>@auto_repair</span>
          </div>
          <div class="d-flex a-center mr-32">
            <div class="sosmed-box-lp mr-14">
              <i class="fab fa-facebook-f"></i>
            </div>
            <span>Auto Repair</span>
          </div>
          <div class="d-flex a-center">
            <div class="sosmed-box-lp mr-14">
              <i class="fab fa-twitter"></i>
            </div>
            <span>@auto_repair</span>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-lp">
      <div class="text-center">
        <span>Copyright 2021 - Auto Repair</span>
        <span></span>
      </div>
    </div>
  </q-page>
</template>

<style>
  html{
    scroll-behavior: smooth;
  }
</style>

<script>
/* eslint-disable */
import { Swiper, SwiperSlide } from 'swiper/vue'
import SwiperCore, { Pagination, Navigation } from 'swiper'
import { getRecommendWorkshop } from '../api/workshopService'
import help from '../js/help'

SwiperCore.use([Pagination, Navigation]);

export default ({
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
  components: {
    Swiper,
    SwiperSlide,
    help
  },
  data () {
    return {
      help,
      token: '',
      workShop: null,
      window: {
        width: 0,
        height: 0
      },
      windowAlter: {
        width: 0,
        height: 0
      },
      search: '',
      workshopRecommendation: []
    }
  },
  mounted () {
    this.doGetRecommendationWorkshop()
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    test () {
      document.getElementById('about-us').scrollIntoView()
    },
    doSearchWorkshop () {
      this.changePage('/workshop?search=' + this.search)
    },
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.windowAlter.width = this.window.width + 400
    },
    doConsole (a) {
      console.log(a)
    },
    changePage (url) {
      this.$router.push(url)
    },
    doGetRecommendationWorkshop(){
      let _this = this
      // if(!help.isObjectEmpty(LocalStorage.getItem('autoRepairUser'))){
      //   _this.token = LocalStorage.getItem('autoRepairUser').data.token
      // } 
      getRecommendWorkshop().then(response => {
        this.workshopRecommendation = response.data.objectReturn
      }) .catch((err) =>{
        console.log(err)
      })
    }
  }
})
</script>
