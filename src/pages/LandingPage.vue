<template>
  <q-page class="landing-page">
    <q-parallax
      class="parallax-lp q-page-height"
    >
      <template v-slot:media>
        <img class="fit-content" src="~assets/images/bg_9.png">
      </template>
      <div class="row" :style="{minHeight: window.alteredHeight + 'px'}">
        <div class="col-md-12">
          <div class="lp-title text-center mb-20">
            <span class="txt-white mr-8">AUTO</span>
            <span class="txt-primary">REPAIR</span>
          </div>
          <div>
            <p class="fs-20 text-white" style="width: 80%; margin: auto; text-align: center;">
              A website created to help people find the nearest car workshop and make appointment with the selected car workshop, according to the services required
            </p>
          </div>
        </div>
        <div class="m-auto col-md-5 col-xs-11 mt-20-i h-100">
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
              <img class="responsive-img fit-content" src="~assets/images/car_stock_img.png" alt="">
            </div>
            <div class="scrolldown-animation m-auto cursor-pointer" @click="doScrollIntoAboutUs()">
              <q-tooltip
                class="bg-primary text-body2"
                transition-show="scale"
                transition-hide="scale"
              >
                About Us
              </q-tooltip>
              <div class="chevrons">
                <div class="chevrondown"></div>
                <div class="chevrondown"></div>
              </div>
            </div>
            <!-- <h4 class="m-auto txt-white cursor-pointer" @click="doScrollIntoAboutUs()">About Us</h4> -->
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
      <div class="text-center" v-if="!help.isObjectEmpty(workshopRecommendation) && !loader">
        <h4 class="m-0 primary_color">Recommendation For You</h4>
        <span class="fs-16">Get the best service experience from us</span>
      </div>
      <div :class="['py-30', {'flex flex-center' : help.isObjectEmpty(workshopRecommendation) && !loader}]" style="min-height: 516px">
        <swiper
          :slidesPerView="window.width < 500 ? 1 : 3"
          :spaceBetween="30"
          :navigation="true"
          :pagination='{
            "clickable": true
          }'
          class="mySwiper lp-swiper"
          v-if="!help.isObjectEmpty(workshopRecommendation) && !loader"
        >
          <swiper-slide v-for="item in workshopRecommendation" :key="item.id">
            <q-card class="my-card rec-card">
              <img class="responsive_img fit-content" src="~assets/images/test_workshop.jpg">
              <q-card-section>
                <div class="d-flex a-start j-sp-between">
                  <div class="text-h6 primary_color mb-8 link_txt_transition" @click="changePage('/workshop/detail/' + item.workshopID)">
                    {{ item.workshopName }}
                  </div>
                  <q-badge v-if="item.status24Hr == '0'" class="tf-capitalize" :color="item.statusHr == 'tutup' ? 'grey-5' : 'primary'">
                    {{ item.statusHr == 'tutup' ? 'Closed' : 'Open' }}
                  </q-badge>
                  <q-badge color="orange-6" v-else>24 Hr</q-badge>
                </div>
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
        <div v-else-if="loader" class="row j-sp-between">
          <q-card class="col-md-4" style="max-width: 436px" v-for="n in 3" :key="'rec-' + n">
            <q-skeleton height="267px" square />
            <q-card-section>
              <div class="d-flex a-start j-sp-between">
                <q-skeleton type="rect" width="80px" />
                <q-skeleton type="text" width="40px" />
              </div>
              <div class="w-85">
                <q-skeleton type="text" />
                <q-skeleton type="text" width="80%" />
                <q-skeleton type="text" width="75%" />
              </div>
              <q-skeleton type="text" width="40%" />
              <div class="d-flex a-center j-sp-between">
                <q-skeleton type="text" width="5%" />
                <q-skeleton type="text" width="10%" />
              </div>
            </q-card-section>
          </q-card>
        </div>
        <div v-else class="maxh-inherit">
          <div v-if="errorMessage || errGeolocationCode == 1 && help.isObjectEmpty(workshopRecommendation)" class="d-flex flex-dir-col text-align-center q-gutter-y-md">
            <q-icon name="fas fa-map-marker-alt" class="fs-100 mb-20 ps-center" color="grey-4" />
            <span class="text-h5">No Location Detected</span>
            <div class="d-flex flex-dir-col">
              <div>
                <span>Looks like you have not turn your location settings, </span>
                <span>
                  <a href="https://support.google.com/chrome/answer/142065?hl=en" target="_blank">Click Here</a> to learn more.
                </span>
              </div>
              <!-- <span>Or <b>refresh</b> the page to automatically prompt request location popup from your browser.</span> -->
            </div>
          </div>
          <div v-else-if="!errorMessage && help.isObjectEmpty(workshopRecommendation)">
            Oops, There is no <b>Workshop Available</b> near you
          </div>
        </div>
      </div>
      <div class="mt-50">
        <div class="text-center">
          <h4 class="m-0 primary_color">How to Use Our Website</h4>
          <span class="fs-16">Get convenience with our website</span>
        </div>
        <q-video class="mt-40-i w-80 m-auto br-10px"
            :ratio="16/6"
            src="https://www.youtube.com/embed/OlHYirmHhK0&ab_channel=baledemy"
          />
      </div>
      <div class="mt-80" id="about-us">
        <div class="text-center">
          <h4 class="m-0 primary_color">Builder Of Our Company</h4>
          <span class="fs-16">Get to know more of the developers</span>
        </div>
        <div class="row">
          <q-card class="my-card br-10px no-shadow col-md-4 col-xs-12 mt-40">
            <q-card-section horizontal class="d-flex j-center">
              <img class="responsive-img dev_pic fit-content about-us-img"
                src="~assets/images/preset/person_1.jpg"
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
          <q-card class="my-card br-10px no-shadow col-md-4 col-xs-12 mt-40">
            <q-card-section horizontal class="d-flex j-center">
              <img class="responsive-img dev_pic fit-content about-us-img"
                src="~assets/images/preset/person_2.png"
              />
              <div class="p-24 pr-36-i card_bg_black_2 text-white d-flex flex-dir-col a-start bg_img_cog_b">
                <span class="fs-20">Nathan Oktavian</span>
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
          <q-card class="my-card br-10px no-shadow col-md-4 col-xs-12 mt-40">
            <q-card-section horizontal class="d-flex j-center">
              <img class="responsive-img dev_pic fit-content about-us-img"
                src="~assets/images/preset/person_3.png"
              />
              <div class="p-24 pr-36-i card_bg_black_2 text-white d-flex flex-dir-col a-start bg_img_cog_b">
                <span class="fs-20">Darryl Egbert</span>
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
      <div class="mt-80 btm-lp row">
        <div class="text-center col-md-12 col-xs-12">
          <h4 class="m-0 primary_color">For More Information</h4>
          <span class="fs-16">Reach out to us.</span>
        </div>
        <div class="sosmed_section text-center m-auto col-md-5 col-xs-12 row">
          <div class="d-flex a-center j-center col-md-4 col-xs-12 mt-30">
            <div class="sosmed-box-lp mr-14">
              <i class="fab fa-instagram"></i>
            </div>
            <span>@auto_repair</span>
          </div>
          <div class="d-flex a-center j-center col-md-4 col-xs-12 mt-30">
            <div class="sosmed-box-lp mr-14">
              <i class="fab fa-facebook-f"></i>
            </div>
            <span>Auto Repair</span>
          </div>
          <div class="d-flex a-center j-center col-md-4 col-xs-12 mt-30">
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
      loader: false,
      errorMessage: false,
      token: '',
      workShop: null,
      window: {
        width: 0,
        height: 0,
        alteredWidth: 0
      },
      search: '',
      workshopRecommendation: [],
      location: {
        lon: null,
        lat: null
      },
      errGeolocationCode: null
    }
  },
  created () {
    // this.doGetCurrentPosition()
  },
  mounted () {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
    this.doGetCurrentPosition()
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    doScrollIntoAboutUs () {
      document.getElementById('about-us').scrollIntoView()
    },
    doSearchWorkshop () {
      this.changePage('/workshop?search=' + this.search)
    },
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
    },
    doGetRecommendationWorkshop(){
      let _this = this
      getRecommendWorkshop(_this.location.lat, _this.location.lon).then(response => {
        this.workshopRecommendation = response.data.objectReturn
        _this.loader = false
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    // doGetCurrentPosition() {
    //   this.loader = true
    //   if(navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(pos => {
    //       this.location.lat = pos.coords.latitude
    //       this.location.lon = pos.coords.longitude
    //       // this.jsonDataParam.lat = ''
    //       // this.jsonDataParam.lon = ''
    //       if(!help.isDataEmpty(this.location.lat) && !help.isDataEmpty(this.location.lon)){
    //         this.doGetRecommendationWorkshop()
    //       } else {
    //         this.errorMessage = true
    //         this.loader = false
    //       }
    //     }, error => {
    //       this.errGeolocationCode = error.code
    //       this.loader = false
    //     })
    //   } else {
    //     this.errorMessage = true
    //     this.loader = false
    //   }
    // },
    showError(error) {
      this.errGeolocationCode = error.code
      switch(error.code) {
        case error.PERMISSION_DENIED:
          this.errorMessage = true
          this.loader = false
          console.log("User denied the request for Geolocation.")
          break;
        case error.POSITION_UNAVAILABLE:
          console.log("Location information is unavailable.")
          break;
        case error.TIMEOUT:
          console.log("The request to get user location timed out.")
          break;
        case error.UNKNOWN_ERROR:
          console.log("An unknown error occurred.")
          break;
      }
    },
    doGetCurrentPosition () {
      navigator.geolocation.getCurrentPosition(pos => {
        console.log(pos)
        this.location.lat = pos.coords.latitude
        this.location.lon = pos.coords.longitude
        this.doGetRecommendationWorkshop()
      }, error => {
        this.showError(error)
      })
    },
    doConsole (a) {
      console.log(a)
    },
    changePage (url) {
      this.$router.push(url)
    },
  }
})
</script>
