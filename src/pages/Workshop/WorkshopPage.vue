<template>
  <q-page-container class="p-30-i lightGrey-bg">
    <q-page v-if="!help.isObjectEmpty(workshops) && !pageLoader">
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
      <div v-if="!filterLoader">
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
              <div>
                <q-card v-for="item in workshops" :key="item.id" class="my-card mb-20 br-20px w-list ml-5 cursor-pointer" @click="doGetWorkshopById(true, clickedId, item.userID)">
                  <q-card-section class="d-flex j-sp-between">
                    <div class="d-flex a-center">
                      <div v-if="!help.isDataEmpty(item.workshopLogo)">
                        <img class="responsive_img fit-content" width="100" :src="item.workshopLogo" alt="">
                      </div>
                      <div class="no-logo-layout-1" v-else>
                        No Logo
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
                        <q-badge color="orange-6" v-else>24 Hr</q-badge>
                      </div>
                      <div class="text-subtitle2 grey-txt">{{ item.distance.toFixed(2) }} Km</div>
                    </div>
                  </q-card-section>
                </q-card>
                <div class="q-gutter-y-sm" v-if="listLoader">
                  <q-skeleton type="QToggle" width="50%" />
                  <q-skeleton type="rect" width="30%" />
                  <q-skeleton type="text" width="20%" />
                </div>
              </div>
            </q-scroll-area>
          </div>
          <div class="col-md-6 pl-16">
            <q-card class="my-card p-20 br-20px" v-if="!help.isObjectEmpty(workshopById.defaultData) && !detailWorkshopLoader">
              <q-card-section>
                <div>
                  <div class="d-flex a-start j-sp-between">
                    <div v-if="!help.isDataEmpty(workshopById.defaultData.workshopLogo)">
                      <img class="responsive_img fit-content" width="100" :src="workshopById.defaultData.workshopLogo" alt="">
                    </div>
                    <div class="no-logo-layout-2" v-else>
                      No Logo
                    </div>
                    <q-badge style="padding:5px 10px" color="primary">
                      <span>Rating</span>
                      <div class="ml-8">
                        <i class="fas fa-star fs-10 mr-5"></i>
                        <span>{{ workshopById.defaultData.rating }}</span>
                      </div>
                    </q-badge>
                  </div>
                  <div class="text-subtitle2 grey-txt my-6">{{ workshopById.defaultData.district }}, {{ workshopById.defaultData.city }}, {{ workshopById.defaultData.province }}</div>
                  <div class="d-flex a-center j-sp-between">
                    <div class="text-h6 mb-6 fw-semibold">{{ workshopById.defaultData.workshopName }}</div>
                    <div class="d-flex a-center">
                      <span class="text-subtitle2">Add to favorite</span>
                      <q-btn
                        @click="!workshopById.defaultData.favoriteToggle ? doAddFavoriteToUser(workshopById.defaultData) : doRemoveFavoriteFromUser(workshopById.defaultData)"
                        :icon="workshopById.defaultData.favoriteToggle ? 'fas fa-heart' : 'far fa-heart'"
                        flat round color="negative"
                      />
                    </div>
                  </div>
                </div>
                <q-separator class="br-5px" color="#605A5A" size="4px" />
                <div class="my-12 row">
                  <div class="col-md-6 w-49-i px-20 min-max-h-241">
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
                        <span v-if="workshopById.defaultData.status24Hr == '0'">{{ help.formatTime(item.operationalOpenHour, help.data().time_2) }} - {{ help.formatTime(item.operationalCloseHour, help.data().time_2) }}</span>
                        <span v-else>Open</span>
                      </div>
                    </div>
                  </div>
                  <q-separator vertical class="br-5px" color="#605A5A" size="4px" />
                  <q-scroll-area
                    :thumb-style="thumbStyle"
                    :bar-style="barStyle"
                    class="col-md-6 w-49-i px-20 min-max-h-241"
                  >
                    <div v-if="!help.isObjectEmpty(workshopById.servisUmum) || !help.isObjectEmpty(workshopById.servisBerkala)">
                      <div class="text-h6 mb-6 sticky-top">Services</div>
                      <div v-if="!help.isObjectEmpty(workshopById.servisUmum)">
                        <span class="fw-semibold">General :</span>
                        <div class="layout_bullet">
                          <div class="wrapper" v-for="(item, index) in workshopById.servisUmum" :key="'g-'+ index">
                            <div class="bullet"></div>
                            <span class="text">{{ item }}</span>
                          </div>
                        </div>
                      </div>
                      <div v-if="!help.isObjectEmpty(workshopById.servisBerkala)">
                        <span class="fw-semibold">Periodic :</span>
                        <div class="layout_bullet">
                          <div class="wrapper" v-for="(item, index) in workshopById.servisBerkala" :key="'p-'+ index">
                            <div class="bullet"></div>
                            <span class="text">{{ item }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <div class="text-h6 mb-6">No Services</div>
                    </div>
                  </q-scroll-area>
                </div>
                <q-separator class="br-5px" color="#605A5A" size="4px" />
              </q-card-section>
              <q-card class="my-card border-card-i br-20px-i m-16">
                <q-card-section>
                  <div class="text-h6">{{ !help.isObjectEmpty(workshopById.defaultData.workshop_review) ? 'Reviews' : 'No Review'}}</div>
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
                          readonly size="xs"
                          color="yellow-14"
                          icon="star_border"
                          icon-selected="star"
                        />
                      </q-card-section>
                    </q-card>
                  </q-scroll-area>
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
            <q-card class="my-card p-20 br-20px bg-transparent" v-else>
              <q-card-section>
                <div>
                  <div class="d-flex a-start j-sp-between">
                    <q-skeleton width="120px" height="90px" />
                    <q-skeleton type="QChip" width="100px" />
                  </div>
                  <q-skeleton type="text" width="150px" />
                  <div class="d-flex a-center j-sp-between">
                    <q-skeleton type="text" width="90px" />
                    <q-skeleton type="rect" width="90px" />
                  </div>
                </div>
                <q-skeleton type="text" width="100%" />
                <div class="my-12 row">
                  <div class="col-md-6 w-45-i px-20 q-gutter-y-md">
                    <q-skeleton class="mb-6" type="text" width="200px" />
                    <q-skeleton type="text" width="150px" v-for="n in 3" :key="'a-' + n" />
                    <q-skeleton type="text" width="130px" />
                    <q-skeleton type="text" width="100px" />
                  </div>
                  <div>
                    <q-skeleton width="5px" height="100%" />
                  </div>
                  <div class="col-md-6 w-45-i px-20 q-gutter-y-md">
                    <q-skeleton class="mb-6" type="text" width="200px" />
                    <q-skeleton type="text" width="150px" v-for="n in 3" :key="'b-' + n" />
                    <q-skeleton type="text" width="130px" />
                    <q-skeleton type="text" width="100px" />
                  </div>
                </div>
                <q-skeleton type="text" width="100%" />
              </q-card-section>
              <q-skeleton class="br-20px-i mx-auto" width="95%" height="80px" />
              <div class="d-flex a-center j-end mt-20">
                <q-skeleton type="QChip" width="150px" />
              </div>
            </q-card>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="my-20">
          <q-skeleton type="rect" width="200px" />
        </div>
        <div class="row">
          <div class="col-md-6">
            <q-scroll-area
              :thumb-style="thumbStyle"
              :bar-style="barStyle"
              class="list-workshop-scrollbar"
              :style="{height: window.heightAltered + 'px'}"
            >
              <div>
                <q-card class="my-card mb-20 br-20px p-20 bg-transparent" v-for="n in 3" :key="'load-l-' + n">
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
                <div class="q-gutter-y-sm">
                  <q-skeleton type="QToggle" width="50%" />
                  <q-skeleton type="rect" width="30%" />
                  <q-skeleton type="text" width="20%" />
                </div>
              </div>
            </q-scroll-area>
          </div>
          <div class="col-md-6 pl-16">
            <q-card class="my-card p-20 br-20px bg-transparent">
              <q-card-section>
                <div>
                  <div class="d-flex a-start j-sp-between">
                    <q-skeleton width="120px" height="90px" />
                    <q-skeleton type="QChip" width="100px" />
                  </div>
                  <q-skeleton type="text" width="150px" />
                  <q-skeleton type="text" width="90px" />
                </div>
                <q-skeleton type="text" width="100%" />
                <div class="my-12 row">
                  <div class="col-md-6 w-45-i px-20 q-gutter-y-md">
                    <q-skeleton class="mb-6" type="text" width="200px" />
                    <q-skeleton type="text" width="150px" v-for="n in 3" :key="'a-' + n" />
                    <q-skeleton type="text" width="130px" />
                    <q-skeleton type="text" width="100px" />
                  </div>
                  <div>
                    <q-skeleton width="5px" height="100%" />
                  </div>
                  <div class="col-md-6 w-45-i px-20 q-gutter-y-md">
                    <q-skeleton class="mb-6" type="text" width="200px" />
                    <q-skeleton type="text" width="150px" v-for="n in 3" :key="'b-' + n" />
                    <q-skeleton type="text" width="130px" />
                    <q-skeleton type="text" width="100px" />
                  </div>
                </div>
                <q-skeleton type="text" width="100%" />
              </q-card-section>
              <q-skeleton class="br-20px-i mx-auto" width="95%" height="80px" />
              <div class="d-flex a-center j-end mt-20">
                <q-skeleton type="QChip" width="150px" />
              </div>
            </q-card>
          </div>
        </div>
      </div>
    </q-page>
    <q-page v-else-if="pageLoader">
      <q-card class="my-card br-20px bg-transparent">
        <q-card-section class="p-35 pb-20">
          <q-skeleton type="rect" width="100px" />
        </q-card-section>
        <q-card-section class="p-35 pt-0 d-flex row">
          <q-skeleton class="col-md-3 mr-auto br-10px" type="QInput" height="56px" />
          <q-skeleton class="col-md-3 mx-auto br-10px" type="QInput" height="56px" />
          <q-skeleton class="col-md-3 ml-auto br-10px" type="QInput" height="56px" />
          <q-skeleton class="ml-auto br-10px" type="QBtn" width="80px" height="56px" />
        </q-card-section>
      </q-card>
      <div class="my-20">
        <q-skeleton type="rect" width="200px" />
      </div>
      <div class="row">
        <div class="col-md-6 pr-20">
          <q-card class="my-card mb-20 br-20px p-20 bg-transparent" v-for="n in 3" :key="'load-l-' + n">
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
          <div class="q-gutter-y-sm">
            <q-skeleton type="QToggle" width="50%" />
            <q-skeleton type="rect" width="30%" />
            <q-skeleton type="text" width="20%" />
          </div>
        </div>
        <div class="col-md-6 pl-16">
          <q-card class="my-card p-20 br-20px bg-transparent">
            <q-card-section>
              <div>
                <div class="d-flex a-start j-sp-between">
                  <q-skeleton width="120px" height="90px" />
                  <q-skeleton type="QChip" width="100px" />
                </div>
                <q-skeleton type="text" width="150px" />
                <div class="d-flex a-center j-sp-between">
                  <q-skeleton type="text" width="90px" />
                  <q-skeleton type="rect" width="90px" />
                </div>
              </div>
              <q-skeleton type="text" width="100%" />
              <div class="my-12 row">
                <div class="col-md-6 w-45-i px-20 q-gutter-y-md">
                  <q-skeleton class="mb-6" type="text" width="200px" />
                  <q-skeleton type="text" width="150px" v-for="n in 3" :key="'a-' + n" />
                  <q-skeleton type="text" width="130px" />
                  <q-skeleton type="text" width="100px" />
                </div>
                <div>
                  <q-skeleton width="5px" height="100%" />
                </div>
                <div class="col-md-6 w-45-i px-20 q-gutter-y-md">
                  <q-skeleton class="mb-6" type="text" width="200px" />
                  <q-skeleton type="text" width="150px" v-for="n in 3" :key="'b-' + n" />
                  <q-skeleton type="text" width="130px" />
                  <q-skeleton type="text" width="100px" />
                </div>
              </div>
              <q-skeleton type="text" width="100%" />
            </q-card-section>
            <q-skeleton class="br-20px-i mx-auto" width="95%" height="80px" />
            <div class="d-flex a-center j-end mt-20">
              <q-skeleton type="QChip" width="150px" />
            </div>
          </q-card>
        </div>
      </div>
    </q-page>
    <q-page class="flex flex-center" v-else>
      <div>
        <div class="d-flex flex-dir-col" v-if="errorMessage || errGeolocationCode == 1 && help.isObjectEmpty(workshops)">
          <figure class="d-flex flex-dir-col">
            <img class="responsive_img fit-content w-50 m-auto" src="~assets/images/preset/no_location_bg.png" alt="">
            <caption class="mt-20 d-flex flex-dir-col">
              <span class="text-h5">No Location Detected</span>
              <div>
                <span>Looks like you have not turn your location settings, </span>
                <span>
                  <a href="https://support.google.com/chrome/answer/142065?hl=en" target="_blank">Click Here</a> to learn more.
                </span>
              </div>
            </caption>
          </figure>
        </div>
        <div v-else-if="!errorMessage && help.isObjectEmpty(workshops)">
          <figure class="d-flex flex-dir-col">
            <img class="responsive_img w-50 m-auto" src="~assets/images/preset/no_workshop_bg.png" alt="">
            <caption class="mt-20">No Data Available.</caption>
          </figure>
        </div>
        <div v-else>
          Error, please contact our admin.
        </div>
      </div>
    </q-page>
  </q-page-container>
</template>

<script>
/* eslint-disable */
import { getWorkshopApi, getWorkshopById, getAllWorkshops } from '../../api/workshopService'
import { addFavoriteToUser, removeFavoriteFromUser, getFavoritesByUserID } from '../../api/FavoriteService'
import help from '../../js/help'
import Auth from '../../js/AuthValidation'
import ValidationFunction from '../../js/ValidationFunction'
import { LocalStorage } from 'quasar'

export default {
  components: {
    ValidationFunction,
    Auth
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
      pageLoader: false,
      filterLoader: false,
      listLoader: false,
      errorMessage: false,
      errGeolocationCode: null,
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
        defaultData: {
          favoriteToggle: false
        },
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
      today: null,
      user: {},
      userToken: null
    }
  },
  created () {
    this.searchFromLP = ValidationFunction.getQueryVariableForURL('search', '')
    if(Auth.isUserLogin()){
      this.user = LocalStorage.getItem('autoRepairUser').data.user
      this.userToken = LocalStorage.getItem('autoRepairUser').data.access_token
    }
    this.setDefaultFilter()
    this.doGetCurrentPosition()
  },
  mounted () {
    this.today = help.formatToday(this.help.data().d_1).toLowerCase()
    if(!this.pageLoader){
      document.querySelector('.q-scrollarea__container').addEventListener('scroll', () => {
        this.loadNextPage()
      })
    }
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
        let tempArrResponse = response.data.objectReturn
        var tempArrWorkshopName = []
        var tempArrDistrict = []
        tempArrResponse.forEach(el1 => {
          tempArrWorkshopName.push(el1.workshopName)
          tempArrDistrict.push(el1.district)
        })
        _this.tempWorkshopNameOptions = ValidationFunction.arrayFilterWithSet(tempArrWorkshopName)
        _this.workshopNameOptions = _this.tempWorkshopNameOptions
        _this.tempLocationOptions = ValidationFunction.arrayFilterWithSet(tempArrDistrict)
        _this.locationOptions = _this.tempLocationOptions

        _this.doGetWorkshopApi(true)
      }) .catch((err) =>{
        console.log(err)
      })
    },
    doGetWorkshopApi (validator, searching) {
      let _this = this
      if(searching) {
        _this.filterLoader = true
      }
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
          this.workshopById.defaultData = {}
        }
        _this.tempWorkshops.data.forEach(item => {
          _this.workshops.push(item)
        })
        _this.clickedId = _this.workshops[0].userID
        if(_this.clickedId != null && validator || searching){
          _this.doGetWorkshopById(false, _this.clickedId, _this.workshops[0].userID)
        }
        _this.pageLoader = false
        _this.filterLoader = false
        _this.listLoader = false
      }) .catch((err) =>{
        console.log(err)
        _this.pageLoader = false
        _this.filterLoader = false
        _this.listLoader = false
      })
    },
    doGetWorkshopById (clicking, clickId, id) {
      let _this = this
      if(clicking && _this.clickedId == id){}
      else {
        _this.detailWorkshopLoader = true
        _this.workshopById.servisBerkala = []
        _this.workshopById.servisUmum = []
        _this.clickedId = id
        getWorkshopById(_this.clickedId).then(response => {
          _this.workshopById.defaultData = response.data
          _this.workshopById.defaultData.workshop_services.forEach(el1 => {
            if(el1.serviceType == 'servis berkala'){
              _this.workshopById.servisBerkala.push(el1)
            } else if (el1.serviceType == 'servis umum') {
              _this.workshopById.servisUmum.push(el1)
            }
          })

          if(!help.isObjectEmpty(_this.workshopById.servisBerkala)){
            let tempArr = []
            _this.workshopById.servisBerkala.forEach(el1 => {
              tempArr.push(el1.serviceDetail)
            })
            _this.workshopById.servisBerkala = ValidationFunction.arrayFilterWithSet(tempArr)
          }
          if(_this.workshopById.servisUmum){
            let tempArr = []
            _this.workshopById.servisUmum.forEach(el1 => {
              tempArr.push(el1.serviceDetail)
            })
            _this.workshopById.servisUmum = ValidationFunction.arrayFilterWithSet(tempArr)
          }

        }) .finally(() => {
          if(Auth.isUserLogin()){
            _this.doGetFavoritesByUserID()
          } else {
            _this.detailWorkshopLoader = false
          }
        }) .catch((err) =>{ 
          console.log(err)
          _this.detailWorkshopLoader = false
        })
      }
    },
    doAddFavoriteToUser (item) {
      let _this = this
      addFavoriteToUser(_this.user.id, item.id, _this.userToken).then(response => {
        item.favoriteToggle = !item.favoriteToggle
        this.$q.notify({
          type: 'positive',
          message: 'Added to favorite!',
          color: 'primary',
          timeout: 1000
        })
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    doRemoveFavoriteFromUser (item) {
      let _this = this
      removeFavoriteFromUser(_this.user.id, item.userID, _this.userToken).then(response => {
        item.favoriteToggle = !item.favoriteToggle
        this.$q.notify({
          type: 'positive',
          message: 'Removed to favorite!',
          color: 'negative',
          timeout: 1000
        })
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    doGetFavoritesByUserID () {
      let _this = this
      let favoriteList = []
      getFavoritesByUserID(_this.user.id, _this.userToken).then(response => {
        favoriteList = response.data.objectReturn
        if(!help.isObjectEmpty(favoriteList)){
          favoriteList = favoriteList.filter(item => item.workshopID === _this.workshopById.defaultData.id)[0]
          if(!help.isDataEmpty(favoriteList)){
            if(favoriteList.customerID == _this.user.id && favoriteList.workshopID == _this.workshopById.defaultData.id){
              _this.workshopById.defaultData.favoriteToggle = true
            }
          }
        }
        _this.detailWorkshopLoader = false
      }) .catch((err) =>{
        console.log(err)
        _this.detailWorkshopLoader = false
      })
    },
    doGetCurrentPosition() {
      this.pageLoader = true
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
          this.jsonDataParam.lat = pos.coords.latitude
          this.jsonDataParam.lon = pos.coords.longitude
          // this.jsonDataParam.lat = ''
          // this.jsonDataParam.lon = ''
          if(!help.isDataEmpty(this.jsonDataParam.lat) && !help.isDataEmpty(this.jsonDataParam.lon)){
            this.doGetAllWorkshopsForAutocomplete()
          } else {
            this.errorMessage = true
            this.pageLoader = false
          }
        }, error => {
          this.errGeolocationCode = error.code
          this.pageLoader = false
        })
      } else { 
        this.errorMessage = true
        this.pageLoader = false
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