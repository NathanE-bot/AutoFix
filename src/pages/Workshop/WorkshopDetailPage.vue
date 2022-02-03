<template>
  <q-page class="wd-page">
    <q-btn
      @click="goBack()"
      unelevated round outline
      size="lg"
      class="back-btn-float_left"
      style="color: white !important"
    >
      <i class="fas fa-arrow-left fs-20"></i>
    </q-btn>
    <q-parallax :height="200" :speed="0.5">
      <template v-slot:media>
        <img class="fit-content" :src="help.checkforBackgroundDetailWorkshopImage(workshop_gallery)">
      </template>
    </q-parallax>
    <div class="bg-white">
      <div class="m-auto w-80 relative-position">
        <div  class="flex flex-center flex-start" style="position:relative; bottom:70px;">
          <div v-if="!help.isDataEmpty(workshopDetail.workshopLogo)">
            <img class="responsive_img detail-workshop-bg fit-content" width="120" :src="workshopDetail.workshopLogo" alt="">
          </div>
          <div class="detail-workshop-bg d-flex a-center j-center" v-else>
            No Logo
          </div>
        </div>
        <div class="d-flex flex-dir-col a-center flex-center content-logo mt-10">
          <div class="text-h4 fw-semibold">
            {{ workshopDetail.workshopName }}
          </div>
          <div class="text-subtitle2">
            {{ workshopDetail.workshopAddress }}, {{ workshopDetail.district }}, {{ workshopDetail.city }}, {{ workshopDetail.province }}
          </div>
        </div>
        <!-- <div class="title-workshop d-flex flex-dir-col a-start">
          <span class="text-h4 fw-bold">{{ workshopDetail.workshopName }}</span>
          <div class="mt-8 d-flex flex-dir-col a-start">
            <div class="d-flex">
              <span class="grey-txt">Address:&nbsp;</span>
              <span class="maxw-240">{{ workshopDetail.workshopAddress }}, {{ workshopDetail.district }}, {{ workshopDetail.city }}, {{ workshopDetail.province }}</span>
            </div>
            <div v-if="!help.isObjectEmpty(tempDistance)">
              <span class="grey-txt">Distance:</span> <span>{{ tempDistance.distance.toFixed(2) }} Km</span>
            </div>
          </div>
        </div> -->
        <div class="rating-workshop d-flex a-center">
          <div class="mr-15" v-if="!help.isObjectEmpty(tempDistance)">
            <span class="text-subtitle2 grey-txt">{{ tempDistance.distance.toFixed(2) }} Km</span>
          </div>
          <q-badge style="padding:5px 10px" color="primary">
            <span>Rating</span>
            <div class="ml-8">
              <i class="fas fa-star fs-10 mr-5"></i>
              <span>{{ workshopDetail.rating }}</span>
            </div>
          </q-badge>
        </div>
        <div class="text-subtitle2 w-description">
          {{ workshopDetail.workshopDescription }}
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <div class="my-12 row">
          <div class="col-md-6 w-49-i px-20">
            <div class="d-flex a-center">
              <div class="text-h6 fw-bold mb-6">Operational Hours</div>
              <q-badge v-if="workshopDetail.status24Hr == '0'" class="tf-capitalize ml-20" :color="workshopDetail.statusHr == 'tutup' ? 'grey-5' : 'primary'">
                {{ workshopDetail.statusHr == 'tutup' ? 'Closed' : 'Open' }}
              </q-badge>
              <q-badge class="ml-20" color="orange-6" v-else>
                24 Hr
              </q-badge>
            </div>
            <div v-for="item in workshopDetail.operational_workshop" :key="item.id">
              <div :class="['d-flex a-center layout_txt', {'primary_bg_fade' : help.formatTodayFormatter(this.today) === item.operationalDate}]">
                <div>
                  <span>
                    {{
                      item.operationalDate == '1' ? 'Monday' :
                      item.operationalDate == '2' ? 'Tuesday' :
                      item.operationalDate == '3' ? 'Wednesday' :
                      item.operationalDate == '4' ? 'Thrusday' :
                      item.operationalDate == '5' ? 'Friday' :
                      item.operationalDate == '6' ? 'Saturday' :
                      item.operationalDate == '0' ? 'Sunday' : '-'
                    }}
                  </span>
                  <span>:</span>
                </div>
                <span>{{ help.formatTime(item.operationalOpenHour, help.data().time_2) }} - {{ help.formatTime(item.operationalCloseHour, help.data().time_2) }}</span>
              </div>
            </div>
          </div>
          <q-separator vertical class="br-5px" color="#605A5A" size="4px" />
          <q-scroll-area
            :thumb-style="thumbStyle"
            :bar-style="barStyle"
            class="col-md-6 w-49-i px-20 min-max-h-241"
          >
            <div class="text-h6 fw-bold mb-6">Services</div>
              <div class="row" v-if="!help.isObjectEmpty(workshop_details)">
                <div v-for="item in workshop_details" :key="item.id" class="col-md-6 py-12">
                  <span class="fw-semibold">{{ item.carType }}</span>
                  <div>
                    <span class="ml-8">Servis Berkala:</span>
                    <div class="layout_bullet fs-12" v-for="item2 in item.workshop_services" :key="item2.id">
                      <div class="wrapper" v-if="item2.serviceType == 'Servis Berkala'">
                        <div class="bullet"></div>
                        <span class="text">{{ item2.serviceDetail }} - {{ ValidationFunction.convertToRupiah(item2.price) }}</span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <span class="ml-8">Servis Umum:</span>
                    <div class="layout_bullet" v-for="item2 in item.workshop_services" :key="item2.id">
                      <div class="wrapper fs-12" v-if="item2.serviceType == 'Servis umum'">
                        <div class="bullet"></div>
                        <span class="text">{{ item2.serviceDetail }} - {{ ValidationFunction.convertToRupiah(item2.price) }}</span>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </q-scroll-area>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <div class="py-20">
          <div class="text-h6 fw-bold mb-10">Gallery</div>
          <div>
            <q-carousel
              v-if="help.isObjectEmpty(workshopDetail.workshop_picture)"
              v-model="gallerySlide"
              arrows swipeable thumbnails
              animated infinite :autoplay="10000"
              transition-prev="slide-right"
              transition-next="slide-left"
              transition-duration="2000"
              control-color="primary"
              class="bg-grey-1 rounded-borders col-12"
              :style="{height: window.heightAltered + 'px'}"
            >
              <q-carousel-slide v-for="n in 4" :key="'AIYE' + n" :name="n" img-src="~assets/images/background_img/car_bg_1.jpg" />
            </q-carousel>
            <q-carousel
              v-else
              v-model="gallerySlide"
              arrows swipeable thumbnails
              animated infinite :autoplay="10000"
              transition-prev="slide-right"
              transition-next="slide-left"
              transition-duration="2000"
              control-color="primary"
              class="bg-grey-1 rounded-borders col-12"
              :style="{height: window.heightAltered + 'px'}"
            >
              <q-carousel-slide v-for="(images, index) in jsonDataParam.galleryImagesForPreview" :key="'AIYE' + index" :name="index+1" :img-src="images.imageData" />
            </q-carousel>
          </div>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <div class="py-20">
          <div class="text-h6 fw-bold">Contact</div>
          <div class="contact-section">
            <div class="d-flex a-center py-30">
              <div class="icon-phone-border d-flex cursor-pointer" @click="copyPhoneNum()">
                <q-icon class="phone-icon" name="phone" />
              </div>
              <div class="content-nomor pl-30 flex flex-center">
                <div class="fs-16 fw-semibold mb-15">Call {{ workshopDetail.workshopName }}</div>
                <div>
                  <input class="text-subtitle2 copy-layout" readonly type="text" v-model="workshopDetail.workshopPhoneNumber" id="copyPhoneNum">
                </div>
              </div>
              <div>
                <q-btn
                  @click="copyPhoneNum()"
                  unelevated
                  color="primary"
                  label="Copy"
                  padding="4px 20px"
                  class="tf-capitalize fw-bold fs-20 br-5px"
                >
                </q-btn>
              </div>
            </div>
            <div class="d-flex a-center py-30">
              <div class="icon-phone-border d-flex cursor-pointer" @click="doMakeChatRoom()">
                <q-icon class="phone-icon" name="chat" />
              </div>
              <div class="content-nomor pl-30 flex flex-center">
                <div class="fs-16 fw-semibold mb-15">Chat Honda Indonesia</div>
                <div class="text-subtitle2">in apps chat message</div>
              </div>
            </div>
            <div class="d-flex a-center py-30">
              <div class="icon-phone-border d-flex"><q-icon class="phone-icon" name="email" /></div>
              <div class="content-nomor pl-30 flex flex-center">
                <div class="fs-16 fw-semibold mb-15">Email Honda Indonesia</div>
                <div class="text-subtitle2">Send Mail to <b class="primary_bg_fade p-2 br-5px">{{ workshopDetail.workshopEmail }}</b></div>
              </div>
            </div>
            <div class="d-flex a-center py-30">
              <div class="icon-phone-border d-flex cursor-pointer" @click="openGoogleMapsWithCoords()">
                <q-icon class="phone-icon" name="fas fa-map-marker-alt" />
              </div>
              <div class="content-nomor pl-30 flex flex-center">
                <div class="fs-16 fw-semibold mb-15">Find Honda Indonesia</div>
                <div class="text-subtitle2">{{ workshopDetail.workshopAddress }}, {{ workshopDetail.district }}, {{ workshopDetail.city }}, {{ workshopDetail.province }}</div>
              </div>
              <div>
                <q-btn
                  @click="openGoogleMapsWithCoords()"
                  unelevated
                  color="primary"
                  label="See on maps"
                  padding="4px 20px"
                  class="tf-capitalize fw-bold fs-20 br-5px"
                >
                </q-btn>
              </div>
            </div>
          </div>
        </div>
        <q-btn
          @click="doCheckLogin()"
          outline color="primary"
          label="Make Your Schedule"
          class="tf-capitalize fw-bold fw my-30 fs-30 br-5px default-btn-1"
        >
        </q-btn>
      </div>
    </div>
  </q-page>
</template>

<script>
/* eslint-disable */
import Auth from '../../js/AuthValidation'
import { LocalStorage } from 'quasar'
import { getWorkshopById, countDistanceFromCurrPos, getUserWorkshopByWorkshopId } from '../../api/workshopService'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'
import main from '../../main'
import Swal from 'sweetalert2'

export default {
  data () {
    return {
      help,
      ValidationFunction,
      LocalStorage,
      thumbStyle: {
        right: '2px',
        borderRadius: '10px',
        backgroundColor: '#21a17b',
        width: '10px',
        opacity: 0.75
      },
      barStyle: {
        right: '2px',
        borderRadius: '10px',
        backgroundColor: '#21a17b',
        width: '10px',
        opacity: 0.2
      },
      window: {
        width: 0,
        height: 0,
        heightAltered: 0
      },
      loader: false,
      userTokenChat: null,
      workshopId: null,
      workshopDetail: [],
      workshop_details: [],
      userWorkshop: '',
      gallerySlide: 1,
      roomId: null,
      today: null,
      currPos: {
        lat: null,
        lon: null
      },
      tempDistance: [],
      workshop_gallery: []
    }
  },
  created () {
    if(LocalStorage.has('autoRepairUser')){
      this.userTokenChat = LocalStorage.getItem('autoRepairUser').data.user.tokenChat
    }
    this.today = this.help.formatToday(this.help.data().d_1).toLowerCase()
    this.workshopId = this.$route.params.id
    if(!help.isDataEmpty(this.workshopId)){
      this.doGetWorkshopById()
    }
  },
  mounted () {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
    if(Auth.isUserLogin() == 'session_expired'){
      Swal.fire({
        icon: 'warning',
        title: 'Session expired',
        text: 'Please re-login'
      }) .then((result) => {
        if(result.isConfirmed){
          this.changePage('/session/login')
        }
      })
    }
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (40/100))
    },
    doCheckLogin () {
      if(!Auth.isUserLogin()){
        Swal.fire({
          title: 'Error',
          text: 'Please login first.',
          confirmButtonText: 'Login',
          confirmButtonColor: '#21a17b',
          showCancelButton: true,
          cancelButtonText: 'Back',
        }) .then((result) => {
          if(result.isConfirmed){
            this.changePage('/session/login')
          }
        })
      } else {
        this.changePage('/member/workshop/make-schedule/' + this.userWorkshop.id)
      }
    },
    doMakeChatRoom () {
      let user_1 = ''
      let user_2 = ''
      if(LocalStorage.has('autoRepairUser')){
        user_1 = LocalStorage.getItem('autoRepairUser').data.user.fullName
        user_2 = this.userWorkshop.fullName
        this.roomId = LocalStorage.getItem('autoRepairUser').data.user.tokenChat + '-' + this.userWorkshop.tokenChat
      }
      if(!help.isDataEmpty(this.roomId)){
        main
          .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
          .ref("chatRoom/" + this.roomId + "/user-1")
          .set(user_1)
        main
          .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
          .ref("chatRoom/" + this.roomId + "/user-2")
          .set(user_2)
        if(help.isDataEmpty(this.userTokenChat)){
          Swal.fire({
            title: 'Error',
            text: 'Please contact website admin.'
          })
        } else {
          this.changePage('/member/home-message?userTokenChat=' + this.userTokenChat + '-' + this.userWorkshop.tokenChat + '&isFromOutside=' + true)
        }
      } else {
        Swal.fire({
          title: 'Error',
          text: 'Please login first.',
          confirmButtonText: 'Login',
          confirmButtonColor: '#21a17b',
          showCancelButton: true,
          cancelButtonText: 'Back',
        }) .then((result) => {
          if(result.isConfirmed){
            this.changePage('/session/login')
          }
        })
      }
    },
    doGetUserWorkshopByWorkshopId (id) {
      let _this = this
      getUserWorkshopByWorkshopId(id).then(response => {
        _this.userWorkshop = response.data
      }).catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    openGoogleMapsWithCoords () {
      if(!help.isDataEmpty(this.workshopDetail.latitude) && !help.isDataEmpty(this.workshopDetail.longitude)){
        var url = "https://maps.google.com/?q=" + this.workshopDetail.latitude + "," + this.workshopDetail.longitude
        window.open(url, '_blank')
      }
    },
    copyPhoneNum () {
      var copyLink = document.getElementById("copyPhoneNum")
      copyLink.select()
      navigator.clipboard.writeText(copyLink.value)
      this.$q.notify({
        badgeStyle: "opacity: 0",
        type: 'positive',
        message: 'Copied to clipboard!',
        color: 'primary',
        timeout: 1000
      })
    },
    doGetCurrentPosition() {
      this.loader = true
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
          this.currPos.lat = pos.coords.latitude
          this.currPos.lon = pos.coords.longitude
          if(!help.isDataEmpty(this.currPos.lat) && !help.isDataEmpty(this.currPos.lon)){
            this.doGetDistanceFromAllWorkshops()
          }
        }, error => {
          console.log(error)
        })
      } else { 
        console.log('no')
      }
    },
    doGetDistanceFromAllWorkshops () {
      let _this = this
      countDistanceFromCurrPos(_this.currPos).then(response => {
        _this.tempDistance = response.data.objectReturn
        _this.tempDistance = _this.tempDistance.filter(item => item.workshopId === _this.workshopDetail.id)[0]
        _this.tempDistance.distance = _this.tempDistance.distance / 1000
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    doGetWorkshopById () {
      let _this = this
      _this.loader = true
      getWorkshopById(_this.workshopId).then(response => {
        _this.workshopDetail = response.data
        _this.doGetUserWorkshopByWorkshopId(_this.workshopDetail.userID)
        _this.doGetCurrentPosition()
        // loopingan data servis
        _this.workshopDetail.workshop_details.forEach(el1 => {
          let tempArr = []
          _this.workshopDetail.workshop_services.forEach(el2 =>{
            if(el2.workshopDetailID === el1.id){
              tempArr.push(el2)
            }
          })
          
          let tempObject = {
            id: el1.id,
            workshopId: el1.workshopId,
            carModel: el1.carModel,
            carType: el1.carType,
            workshop_services: tempArr,
            created_at: el1.created_at,
            updated_at: el1.updated_at,
          }
          _this.workshop_details.push(tempObject)
        })
        _this.loader = false
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    changePage (url) {
      this.$router.push(url)
    },
    goBack(){
      this.$router.go(-1)
    }
  }
}
</script>
