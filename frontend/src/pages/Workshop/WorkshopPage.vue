<template>
    <q-page class="p-30 lightGrey-bg">
      <q-card class="my-card br-20px">
        <q-card-section class="p-35 pb-20">
          <span class="fw-bold fs-20">Workshop</span>
        </q-card-section>
        <q-card-section class="p-35 pt-0 d-flex row">
          <!-- <q-select
            @filter="doFilterOption"
            v-model="searchKeywordTemp"
            :options="tempItems"
            use-input input-debounce="0" outlined hide-dropdown-icon
            :placeholder="searchKeyword == null || searchKeyword == '' ? 'Cari workshop...' : ''"
            class="col-md-3 mr-auto default-select"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
            <template v-slot:prepend>
              <q-icon name="search"></q-icon>
            </template>
          </q-select>
          <q-select
            v-model="searchLocation"
            :options="locationOptions"
            use-input input-debounce="0" outlined hide-dropdown-icon
            :placeholder="searchLocation == null || searchLocation == '' ? 'Jakarta Barat, Tangerang...' : ''"
            class="col-md-3 mx-auto default-select"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
            <template v-slot:prepend>
              <q-icon name="search"></q-icon>
            </template>
          </q-select>
          <q-select
            v-model="filterTypeModel"
            :options="filterType"
            outlined
            class="col-md-3 mx-auto default-select"
          >
          </q-select> -->
          <q-btn
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
            <q-card v-for="item in workshops" :key="item.id" class="my-card mb-20 br-20px w-list ml-5 cursor-pointer" @click="clickedId = item.userID; doGetWorkshopById()">
              <q-card-section class="d-flex a-start">
                <div>
                  <img class="img-responsive" width="100" src="~assets/images/logo/workshop/honda.png" alt="">
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
              </q-card-section>
            </q-card>
            <q-card class="my-card mb-20 br-20px p-20" v-if="listLoader">
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
          </q-scroll-area>
        </div>
        <div class="col-md-6 pl-16">
          <q-card class="my-card p-20 br-20px" v-if="!help.isObjectEmpty(workshopById.defaultData)">
            <q-card-section>
              <div>
                <div class="d-flex a-start j-sp-between">
                  <img class="img-responsive" width="100" src="~assets/images/logo/workshop/honda.png" alt="">
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
                    <div :class="['d-flex a-center layout_txt', {'primary_bg_fade' : help.formatTodayFormatter(this.today) == item.operationalDate}]">
                      <div>
                        <span>
                          {{
                            item.operationalDate == '0' ? 'Senin' :
                            item.operationalDate == '1' ? 'Selasa' :
                            item.operationalDate == '2' ? 'Rabu' :
                            item.operationalDate == '3' ? 'Kamis' :
                            item.operationalDate == '4' ? 'Jumat' :
                            item.operationalDate == '5' ? 'Sabtu' :
                            item.operationalDate == '6' ? 'Minggu' : ''
                          }}
                        </span>
                        <span>:</span>
                      </div>
                      <span>{{ help.formatTime(item.operationalOpenHour, help.data().time_2) }} - {{ help.formatTime(item.operationalCloseHour, help.data().time_2) }}</span>
                    </div>
                  </div>
                </div>
                <q-separator vertical class="br-5px" color="#605A5A" size="4px" />
                <div class="col-md-6 w-45-i px-20">
                  <div class="text-h6 mb-6">Services</div>
                  <span class="fw-semibold">Umum :</span>
                  <div class="layout_bullet">
                    <div class="wrapper" v-for="item in workshopById.servisUmum" :key="item.id">
                      <div class="bullet"></div>
                      <span class="text">{{ item.serviceDetail }}</span>
                    </div>
                  </div>
                  <span class="fw-semibold">Berkala :</span>
                  <div class="layout_bullet">
                    <div class="wrapper" v-for="item in workshopById.servisBerkala" :key="item.id">
                      <div class="bullet"></div>
                      <span class="text">{{ item.serviceDetail }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <q-separator class="br-5px" color="#605A5A" size="4px" />
            </q-card-section>
            <q-card class="my-card border-card-i br-20px-i m-16">
              <q-card-section>
                <div class="text-h6">Reviews</div>
                <q-scroll-area
                  :thumb-style="thumbStyle"
                  :bar-style="barStyle"
                  class="review-workshop-scrollbar"
                  :style="{height: window.heightAlteredReview + 'px'}"
                >
                  <q-card class="my-card review-card br-20px">
                    <q-card-section class="relative-position">
                      <span class="review-date grey-5">08/09/2021</span>
                      <div class="review-content">
                        <div class="text-h6">Bambang</div>
                        <div class="line-clamp-3 text-subtitle2 fs-12">testing testing</div>
                      </div>
                      <q-rating
                        class="review-rating"
                        v-model="ratingModel"
                        readonly
                        size="xs"
                        color="yellow-14"
                        icon="star_border"
                        icon-selected="star"
                      />
                    </q-card-section>
                  </q-card>
                </q-scroll-area>
              </q-card-section>
            </q-card>
          </q-card>
        </div>
      </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getWorkshopByStatusUpdate, getWorkshopById } from '../../api/workshopService'
import help from '../../js/help'

export default {
  data () {
    return {
      help,
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
      searchKeyword: null,
      searchKeywordTemp: null,
      items: [],
      tempItems: [],
      filterTypeModel: 'Semua',
      filterType: ['Semua', 'Buka', 'Tutup', '24 Jam'],
      searchLocation: null,
      locationOptions: [],
      tempWorkshops: [],
      workshops: [],
      totalWorkshop: 0,
      jsonDataParam: {
        iPage: 1
      },
      clickedId: null,
      workshopById: {
        defaultData: [],
        servisBerkala: [],
        servisUmum: []
      },
      ratingModel: 4
    }
  },
  created () {
    this.doGetWorkshopByStatusUpdate(true)
  },
  mounted () {
    this.today = this.help.formatToday(this.help.data().d_1).toLowerCase()
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
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (14/100))
      this.window.heightAlteredReview = window.innerHeight - (window.innerHeight * (86/100))
    },
    // doFilterOption (val, update) {
    //   if (val === '') {
    //     update(() => {
    //       this.tempItems = this.items
    //     })
    //     return
    //   }
    //   update(() => {
    //     let needle = val.toLowerCase()
    //     this.tempItems = this.items.filter(v => v.toLowerCase().indexOf(needle) > -1)
    //     this.searchKeyword = needle
    //   })
    //   console.log(this.items, this.tempItems, this.searchKeyword, this.searchKeywordTemp)
    // },
    // doLoopForFilter (array) {
    //   array.forEach(item => {
    //     // let tempObj = {
    //     //   label: item.workshopName,
    //     //   id: item.id
    //     // }
    //     let tempString = item.workshopName
    //     this.items.push(tempString)
    //   })
    // },
    doGetWorkshopByStatusUpdate(validator) {
      let _this = this
      _this.loader = true
      getWorkshopByStatusUpdate(_this.jsonDataParam.iPage).then(response => {
        _this.tempWorkshops = response.data.objectReturn
        console.log(_this.tempWorkshops)
        _this.totalWorkshop = _this.tempWorkshops.length
        _this.tempWorkshops.forEach(item => {
          _this.workshops.push(item)
        })
        _this.clickedId = _this.workshops[0].userID
        if(_this.clickedId != null && validator){
          _this.doGetWorkshopById()
        }
        _this.loader = false
        _this.listLoader = true
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    loadNextPage () {
      let workshopList = document.getElementsByClassName("q-scrollarea__container")[0]
      let workshopListScrollTillBottom = workshopList.scrollHeight - workshopList.clientHeight 
      if (workshopListScrollTillBottom <= workshopList.scrollTop) {
        if(this.jsonDataParam.iPage < this.tempWorkshops.last_page){
          this.listLoader = true
          this.jsonDataParam.iPage++
          this.doGetWorkshopByStatusUpdate(false)
        } else {
          this.listLoader = false
        }
      }
    },
    doGetWorkshopById () {
      let _this = this
      _this.detailWorkshopLoader = true
      getWorkshopById(_this.clickedId).then(response => {
        _this.workshopById.defaultData = response.data[0]
        console.log(_this.workshopById.defaultData)
        // loopingan data servis
        _this.workshopById.defaultData.workshop_details.forEach(el1 => {
          console.log('el1', el1.workshop_services)
          for (const index in el1.workshop_services) {
            if(el1.workshop_services[index].serviceType == 'Servis Berkala'){
              _this.workshopById.servisBerkala.push(el1.workshop_services[index])
            } else {
              _this.workshopById.servisUmum.push(el1.workshop_services[index])
            }
          }
        })
        // filter duplicated
        const tempServisBerkala = _this.workshopById.servisBerkala.map(o => o.serviceDetail)
        const filteredServisBerkala = _this.workshopById.servisBerkala.filter(({serviceDetail}, index) => !tempServisBerkala.includes(serviceDetail, index + 1))

        const tempServisUmum = _this.workshopById.servisUmum.map(o => o.serviceDetail)
        const filteredServisUmum = _this.workshopById.servisUmum.filter(({serviceDetail}, index) => !tempServisUmum.includes(serviceDetail, index + 1))

        _this.workshopById.servisBerkala = filteredServisBerkala
        _this.workshopById.servisUmum = filteredServisUmum

        console.log('sb', _this.workshopById.servisBerkala)
        console.log('su', _this.workshopById.servisUmum)
        _this.detailWorkshopLoader = false
      }) .catch((err) =>{
        console.log(err)
        _this.detailWorkshopLoader = false
      })
    },
    doConsole(a){
      console.log(a);
    }
  }
}
</script>