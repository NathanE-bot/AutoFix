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
    <q-parallax :height="120" :speed="0.5">
      <template v-slot:media>
        <img src="~assets/images/background_img/car_bg_1.jpg">
      </template>
    </q-parallax>
    <div class="bg-white">
      <div class="m-auto w-80 relative-position">
        <div  class="flex flex-center flex-start" style="position:relative; bottom:70px;">
            <img class="responsive_img detail-workshop-bg" width="120" src="~assets/images/logo/workshop/honda.png" alt="">
        </div>
        <div class="flex flex-center flex-start content-logo mt-10">
          {{ workshopDetail.district }}, {{ workshopDetail.city }}
        </div>
        <div class="title-workshop d-flex flex-dir-col a-start">
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
        </div>
        <div class="rating-workshop">
          <div class="soft-badge-primary">
            <span>Rating</span>
            <div>
              <i class="fas fa-star fs-10"></i>
              <span>{{ workshopDetail.rating }}</span>
            </div>
          </div>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
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
          <div class="col-md-6 w-49-i px-20">
            <div class="text-h6 fw-bold mb-6">Services</div>
              <div class="row" v-if="!help.isObjectEmpty(workshop_details)">
                <div v-for="item in workshop_details" :key="item.id" class="mr-10">
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
          </div>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <div class="py-20">
          <div class="text-h6 fw-bold mb-10">Gallery</div>
          <div>
            <q-carousel
              v-model="gallerySlide"
              arrows swipeable thumbnails
              animated infinite :autoplay="10000"
              transition-prev="slide-right"
              transition-next="slide-left"
              transition-duration="2000"
              control-color="primary"
              class="bg-grey-1 rounded-borders"
            >
              <q-carousel-slide :name="1" img-src="~assets/images/background_img/car_bg_1.jpg" />
              <q-carousel-slide :name="2" img-src="~assets/images/background_img/car_bg_1.jpg" />
              <q-carousel-slide :name="3" img-src="~assets/images/background_img/car_bg_1.jpg" />
              <q-carousel-slide :name="4" img-src="~assets/images/background_img/car_bg_1.jpg" />
            </q-carousel>
          </div>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <div class="py-20">
          <div class="text-h6 fw-bold">Contact</div>
          <div class="contact-section">
            <div class="d-flex a-center py-30">
              <div class="icon-phone-border d-flex">
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
              <div class="icon-phone-border d-flex">
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
                <div class="text-subtitle2">Send Mail to honda</div>
              </div>
            </div>
            <div class="d-flex a-center py-30">
              <div class="icon-phone-border d-flex">
                <q-icon class="phone-icon" name="people" />
              </div>
              <div class="content-nomor pl-30 flex flex-center">
                <div class="fs-16 fw-semibold mb-15">Find Honda Indonesia</div>
                <div class="text-subtitle2">Jl. agustin raya nomor 5</div>
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
          outline color="primary"
          label="Make Your Schedule"
          class="tf-capitalize fw-bold fw my-30 fs-30 br-5px"
        >
        </q-btn>
      </div>
    </div>
  </q-page>
</template>

<script>
/* eslint-disable */
import { getWorkshopById, countDistanceFromCurrPos } from '../../api/workshopService'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'

export default {
  data () {
    return {
      help,
      ValidationFunction,
      loader: false,
      workshopId: null,
      workshopDetail: [],
      workshop_details: [],
      gallerySlide: 1,
      today: null,
      currPos: {
        lat: null,
        lon: null
      },
      tempDistance: [],
      isCopied: false,
      isCopiedClick: false
    }
  },
  created () {
    this.today = this.help.formatToday(this.help.data().d_1).toLowerCase()
    this.workshopId = this.$route.params.id
    if(!help.isDataEmpty(this.workshopId)){
      this.doGetWorkshopById()
    }
  },
  methods: {
    openGoogleMapsWithCoords () {
      if(!help.isDataEmpty(this.workshopDetail.latitude) && !help.isDataEmpty(this.workshopDetail.longitude)){
        var url = "https://maps.google.com/?q=" + this.workshopDetail.latitude + "," + this.workshopDetail.longitude
        window.open(url, '_blank')
      }
    },
    copyPhoneNum () {
      this.isCopied = true
      var copyLink = document.getElementById("copyPhoneNum")
      copyLink.select()
      navigator.clipboard.writeText(copyLink.value)
      setTimeout(() => {
        this.isCopied = false
      }, 2000)
      this.$q.notify({
        badgeStyle: "opacity: 0",
        message: 'Copied',
        color: 'primary'
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
        console.log(_this.workshopDetail)
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
          console.log('yeet', tempObject)
          _this.workshop_details.push(tempObject)
        })
        console.log(_this.workshop_details)
        _this.loader = false
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    goBack(){
      this.$router.go(-1)
    }
  }
}
</script>
