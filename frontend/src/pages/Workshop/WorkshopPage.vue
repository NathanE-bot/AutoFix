<template>
    <q-page class="p-30 lightGrey-bg">
      <q-card class="my-card br-20px">
        <q-card-section class="p-35 pb-20">
          <span class="fw-bold fs-20">Workshop</span>
        </q-card-section>
        <q-card-section class="p-35 pt-0 d-flex row">
          <q-select
            v-model="jsonDataParam.workshopName"
            :options="workshopNameOptions"
            @filter="filterWName"
            @input-value="setModelWName"
            use-input input-debounce="0" fill-input hide-selected outlined
            placeholder="Find Workshop..."
            class="col-md-3 mr-auto br-10px default-select-2"
          >
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-select>
          <q-select
            v-model="jsonDataParam.location"
            :options="locationOptions"
            @filter="filterLocation"
            @input-value="setModelLocation"
            use-input input-debounce="0" fill-input hide-selected outlined
            placeholder="Jakarta, Tangerang..."
            class="col-md-3 mx-auto br-10px default-select-2"
          >
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-select>
          <q-select
            v-model="jsonDataParam.status"
            :options="statusOptions"
            outlined
            class="col-md-3 ml-auto br-10px default-select-2"
          >
          </q-select>
          <q-btn
            @click="doGetWorkshopApi(false, true)"
            color="primary"
            size="md" unelevated
            label="Search"
            padding="16px 24px"
            class="fw-semibold ml-auto br-10px"
          >
          </q-btn>
        </q-card-section>
      </q-card>
      <div class="my-20">
        <span class="fw-bold fs-20">Total Workshop : {{ totalWorkshop }}</span>
      </div>
      <div class="row">
        <div class="col-md-6">
          <q-scroll-area
            :thumb-style="thumbStyle"
            :bar-style="barStyle"
            class="list-workshop-scrollbar"
            :style="{height: window.heightAltered + 'px'}"
          >
            <div v-if="!help.isObjectEmpty(workshops)">
              <q-card v-for="item in workshops" :key="item.id" class="my-card mb-20 br-20px w-list ml-5 cursor-pointer" @click="doGetWorkshopById(true, clickedId, item.userID)">
                <q-card-section class="d-flex j-sp-between">
                  <div class="d-flex a-center">
                    <div>
                      <img class="responsive_img" width="100" src="~assets/images/logo/workshop/honda.png" alt="">
                    </div>
                    <div class="ml-20">
                      <div class="text-h6 fw-semibold">{{ item.workshopName }}</div>
                      <div class="text-subtitle2 grey-txt">{{ item.district }}, {{ item.city }}, {{ item.province }}</div>
                      <div class="d-flex a-baseline">
                        <span class="text-subtitle2 grey-txt">Rating: {{ item.rating }}</span>
                      </div>
                      <div class="text-subtitle2">
                        {{ item.workshopDescription }}
                      </div>
                    </div>
                  </div>
                  <div class="d-flex flex-dir-col a-end j-sp-between">
                    <div>
                      <q-badge v-if="item.status24Hr == '0'" class="tf-capitalize" :color="item.statusHr == 'tutup' ? 'grey-5' : 'primary'">
                        {{ item.statusHr == 'tutup' ? 'Closed' : 'Open' }}
                      </q-badge>
                      <q-badge color="orange-6" v-else>
                        24 Hr
                      </q-badge>
                    </div>
                    <div class="text-subtitle2 grey-txt">{{ item.distance.toFixed(2) }} Km</div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="my-card mb-20 br-20px p-20" style="background-color:transparent" v-if="listLoader">
                <q-card-section class="d-flex a-start">
                  <div>
                    <q-skeleton width="100px" height="80px" />
                  </div>
                  <div class="ml-20">
                    <q-skeleton width="220px" type="text" />
                    <q-skeleton width="300px" type="rect" />
                    <q-skeleton width="60px" type="text" />
                    <q-skeleton width="280px" type="text" />
                  </div>
                </q-card-section>
              </q-card>
            </div>
            <div v-else>
              No Data
            </div>
          </q-scroll-area>
        </div>
        <div class="col-md-6 pl-16">
          <q-card class="my-card p-20 br-20px" v-if="!help.isObjectEmpty(workshopById.defaultData) && !detailWorkshopLoader">
            <q-card-section>
              <div>
                <div class="d-flex a-start j-sp-between">
                  <img class="responsive_img" width="100" src="~assets/images/logo/workshop/honda.png" alt="">
                  <div class="soft-badge-primary">
                    <span>Rating</span>
                    <div>
                      <i class="fas fa-star fs-10"></i>
                      <span>{{ workshopById.defaultData.rating }}</span>
                    </div>
                  </div>
                </div>
                <div class="text-subtitle2 grey-txt my-6">{{ workshopById.defaultData.district }}, {{ workshopById.defaultData.city }}, {{ workshopById.defaultData.province }}</div>
                <div class="text-h6 mb-6">{{ workshopById.defaultData.workshopName }}</div>
              </div>
              <q-separator class="br-5px" color="#605A5A" size="4px" />
              <div class="my-12 row">
                <div class="col-md-6 w-45-i px-20">
                  <div class="text-h6 mb-6">Operational Hours</div>
                  <div v-for="item in workshopById.defaultData.operational_workshop" :key="item.id">
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
                <div class="col-md-6 w-45-i px-20" v-if="!help.isObjectEmpty(workshopById.servisUmum) && !help.isObjectEmpty(workshopById.servisBerkala)">
                  <div class="text-h6 mb-6">Services</div>
                  <div v-if="!help.isObjectEmpty(workshopById.servisUmum)">
                    <span class="fw-semibold">General :</span>
                    <div class="layout_bullet">
                      <div class="wrapper" v-for="item in workshopById.servisUmum" :key="item.id">
                        <div class="bullet"></div>
                        <span class="text">{{ item.serviceDetail }}</span>
                      </div>
                    </div>
                  </div>
                  <div v-if="!help.isObjectEmpty(workshopById.servisBerkala)">
                    <span class="fw-semibold">Periodic :</span>
                    <div class="layout_bullet">
                      <div class="wrapper" v-for="item in workshopById.servisBerkala" :key="item.id">
                        <div class="bullet"></div>
                        <span class="text">{{ item.serviceDetail }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>
                  No Services
                </div>
              </div>
              <q-separator class="br-5px" color="#605A5A" size="4px" />
            </q-card-section>
            <q-card class="my-card border-card-i br-20px-i m-16">
              <q-card-section>
                <div class="text-h6">Reviews</div>
                <q-scroll-area
                  v-if="!help.isObjectEmpty(workshopById.defaultData.workshop_review)"
                  :thumb-style="thumbStyle"
                  :bar-style="barStyle"
                  class="review-workshop-scrollbar"
                  :style="{height: window.heightAlteredReview + 'px'}"
                >
                  <q-card class="my-card review-card br-20px mb-20" v-for="review in workshopById.defaultData.workshop_review" :key="review.id">
                    <q-card-section class="relative-position">
                      <span class="review-date grey-5">{{ help.defaultFormat(review.reviewDate, help.data().dmy_6) }}</span>
                      <div class="review-content">
                        <div class="text-h6">{{ review.userName }}</div>
                        <div class="line-clamp-3 text-subtitle2 fs-12">{{ review.description }}</div>
                      </div>
                      <q-rating
                        class="review-rating"
                        v-model="review.rating"
                        readonly
                        size="xs"
                        color="yellow-14"
                        icon="star_border"
                        icon-selected="star"
                      />
                    </q-card-section>
                  </q-card>
                </q-scroll-area>
                <div v-else>
                  <span class="text-subtitle2">No Reviews</span>
                </div>
              </q-card-section>
            </q-card>
            <div class="d-flex a-center j-end">
              <q-btn
                @click="changePage('/workshop/detail/' + workshopById.defaultData.id)"
                color="primary" rounded unelevated padding="4px 24px"
                label="See Full Profile"
                class="tf-capitalize"
              >
              </q-btn>
            </div>
          </q-card>
          <q-card class="my-card p-20 br-20px" style="background-color:transparent" v-else>
            <q-card-section>
              <div>
                <div class="d-flex a-start j-sp-between">
                  <q-skeleton width="100px" height="90px" />
                  <q-skeleton type="QChip" />
                </div>
                <q-skeleton type="text" width="200px" />
                <q-skeleton type="rect" width="80px" />
              </div>
              <div class="my-12 row">
                <div class="col-md-6 w-45-i px-20 q-gutter-y-xs">
                  <q-skeleton type="rect" width="140px" />
                  <q-skeleton type="rect" width="130px" />
                  <q-skeleton type="rect" width="120px" />
                </div>
                <div class="col-md-6 w-45-i px-20 q-gutter-y-xs">
                  <q-skeleton type="rect" width="140px" />
                  <q-skeleton type="rect" width="130px" />
                  <q-skeleton type="rect" width="120px" />
                </div>
              </div>
            </q-card-section>
            <div class="p-30 q-gutter-y-md">
              <q-skeleton type="rect" width="80px" />
              <q-skeleton height="90px" />
            </div>
          </q-card>
        </div>
      </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getWorkshopApi, getWorkshopById, getAllWorkshops } from '../../api/workshopService'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'

export default {
  components: {
    ValidationFunction
  },
  data () {
    return {
      help,
      ValidationFunction,
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
        heightAltered: 0,
        heightAlteredReview: 0
      },
      loader: false,
      listLoader: false,
      detailWorkshopLoader: false,
      allWorkshops: [],
      tempWorkshops: [],
      workshops: [],
      totalWorkshop: 0,
      jsonDataParam: {
        iPage: 1,
        workshopName: '',
        location: '',
        status: 'Semua',
        statusHr: '',
        status24Hr: '',
        lat: null,
        lon: null
      },
      clickedId: null,
      workshopById: {
        defaultData: [],
        servisBerkala: [],
        servisUmum: []
      },
      ratingModel: 4,
      workshopNameOptions: [],
      tempWorkshopNameOptions: [],
      locationOptions: [],
      tempLocationOptions: [],
      statusOptions: ['Semua', 'Buka', 'Tutup', '24 Jam'],
      tempDistance: [],
      today: null
    }
  },
  created () {
    this.searchFromLP = ValidationFunction.getQueryVariableForURL('search', '')
    this.setDefaultFilter()
    this.doGetCurrentPosition()
    this.doGetAllWorkshopsForAutocomplete()
  },
  mounted () {
    this.today = help.formatToday(this.help.data().d_1).toLowerCase()
    document.querySelector('.q-scrollarea__container').addEventListener('scroll', () => {
      this.loadNextPage()
      console.log('scrolling')
    })
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    filterWName (val, update, abort) {
      update(() => {
        const needle = val.toLocaleLowerCase()  
        this.workshopNameOptions = this.tempWorkshopNameOptions.filter(v => v.toLocaleLowerCase().indexOf(needle) > -1)
      })
    },
    setModelWName (val) {
      this.jsonDataParam.workshopName = val
    },
    filterLocation (val, update, abort) {
      update(() => {
        const needle = val.toLocaleLowerCase()  
        this.locationOptions = this.tempLocationOptions.filter(v => v.toLocaleLowerCase().indexOf(needle) > -1)
      })
    },
    setModelLocation (val) {
      this.jsonDataParam.location = val
    },
    setDefaultFilter () {
      this.jsonDataParam.workshopName = ''
      this.jsonDataParam.location = ''
      this.jsonDataParam.statusHr = ''
      this.jsonDataParam.status24Hr = ''
    },
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (11/100))
      this.window.heightAlteredReview = window.innerHeight - (window.innerHeight * (84/100))
    },
    loadNextPage () {
      let workshopList = document.getElementsByClassName("q-scrollarea__container")[0]
      let workshopListScrollTillBottom = workshopList.scrollHeight - workshopList.clientHeight
      if (workshopListScrollTillBottom <= workshopList.scrollTop) {
        if(this.jsonDataParam.iPage < this.tempWorkshops.last_page){
          this.listLoader = true
          this.jsonDataParam.iPage++
          this.doGetWorkshopApi(false)
        } else {
          this.listLoader = false
        }
      }
    },
    doGetAllWorkshopsForAutocomplete () {
      let _this = this
      getAllWorkshops().then(response => {
        let forWorkshopName = response.data.objectReturn
        let forDistrict = response.data.objectReturn
        forWorkshopName = ValidationFunction.arrayFilterWName(forWorkshopName)
        forDistrict = ValidationFunction.arrayFilterDistrict(forDistrict)

        forWorkshopName.forEach(el1 => {
          _this.tempWorkshopNameOptions.push(el1.workshopName)
          _this.workshopNameOptions.push(el1.workshopName)
        })

        forDistrict.forEach(el1 => {
          _this.locationOptions.push(el1.district)
          _this.tempLocationOptions.push(el1.district)
        })

      }) .catch((err) =>{
        console.log(err)
      })
    },
    doGetWorkshopApi (validator, searching) {
      let _this = this
      if(!help.isDataEmpty(_this.searchFromLP)){
        _this.jsonDataParam.workshopName = _this.searchFromLP
      }
      if(_this.jsonDataParam.status == 'Semua'){
        _this.jsonDataParam.statusHr = ''
        _this.jsonDataParam.status24Hr = ''
      } else if (_this.jsonDataParam.status == 'Buka'){
        _this.jsonDataParam.statusHr = 'Buka'
        _this.jsonDataParam.status24Hr = ''
      } else if (_this.jsonDataParam.status == 'Tutup'){
        _this.jsonDataParam.statusHr = 'Tutup'
        _this.jsonDataParam.status24Hr = ''
      } else if (_this.jsonDataParam.status == '24 Jam') {
        _this.jsonDataParam.statusHr = ''
        _this.jsonDataParam.status24Hr = '1'
      }
      getWorkshopApi(_this.jsonDataParam).then(response => {
        _this.tempWorkshops = response.data.objectReturn
        _this.totalWorkshop = response.data.objectReturn.total
        if(searching){
          _this.workshops = []
        }
        if(_this.totalWorkshop == 0){
          this.workshopById.defaultData = []
        }
        _this.tempWorkshops.data.forEach(item => {
          _this.workshops.push(item)
        })
        _this.clickedId = _this.workshops[0].userID
        if(_this.clickedId != null && validator || searching){
          _this.doGetWorkshopById(false, _this.clickedId, _this.workshops[0].userID)
        }
        _this.loader = false
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },

    doGetWorkshopById (clicking, clickId, id) {
      let _this = this
      console.log(_this.clickedId , id)
      if(clicking && _this.clickedId == id){} 
      else {
        _this.detailWorkshopLoader = true
        _this.workshopById.servisBerkala = []
        _this.workshopById.servisUmum = []
        _this.clickedId = id
        getWorkshopById(_this.clickedId).then(response => {
          _this.workshopById.defaultData = response.data
          _this.workshopById.defaultData.workshop_services.forEach(el1 => {
            if(el1.serviceType == 'Servis Berkala'){
              _this.workshopById.servisBerkala.push(el1)
            } else {
              _this.workshopById.servisUmum.push(el1)
            }
          })
          _this.workshopById.servisBerkala = ValidationFunction.arrayFilter(_this.workshopById.servisBerkala)
          _this.workshopById.servisUmum = ValidationFunction.arrayFilter(_this.workshopById.servisUmum)
          _this.detailWorkshopLoader = false
          console.log(_this.workshopById.defaultData)
          console.log(_this.workshopById.servisBerkala, _this.workshopById.servisUmum)
        }) .catch((err) =>{ 
          console.log(err)
          _this.detailWorkshopLoader = false
        })
      }
      
    },
    doGetCurrentPosition() {
      this.loader = true
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
          this.jsonDataParam.lat = pos.coords.latitude
          this.jsonDataParam.lon = pos.coords.longitude
          if(!help.isDataEmpty(this.jsonDataParam.lat) && !help.isDataEmpty(this.jsonDataParam.lon)){
            this.doGetWorkshopApi(true)
          }
        }, error => {
          console.log(error)
        })
      } else { 
        console.log('no')
      }
    },
    doConsole(a){
      console.log(a);
    },
    changePage(url) {
      this.$router.push(url)
    }
  }
}
</script>