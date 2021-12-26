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
          <q-btn
            @click="jsonDataParam.iPage += 1; doGetWorkshopByStatusUpdate()">
            LEGO
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
            <q-card v-for="item in workshops" :key="item.id" class="my-card mb-20 br-20px p-20">
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
          </q-scroll-area>
        </div>
        <div class="col-md-6 pl-16">
          <q-card class="my-card">
            <q-card-section>
              <div class="text-h6">Our Changing Planet</div>
              <div class="text-subtitle2">by John Doe</div>
            </q-card-section>
            <q-card-section>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </q-card-section>
          </q-card>
        </div>
      </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getWorkshopByStatusUpdate } from '../../api/workshopService'
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
        heightAltered: 0
      },
      loader: false,
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
      fullData: false
    }
  },
  created () {
    this.doGetWorkshopByStatusUpdate()
  },
  mounted () {
    document.querySelector('.q-scrollarea__container').addEventListener('scroll', () => {
      // this.loadNextPage()
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
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (22/100))
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
    doGetWorkshopByStatusUpdate () {
      let _this = this
      _this.loader = true
        getWorkshopByStatusUpdate(this.jsonDataParam.iPage).then(response => {
          _this.tempWorkshops = response.data.objectReturn
          _this.totalWorkshop = _this.tempWorkshops.total
          if(!_this.fullData){
            _this.tempWorkshops.data.forEach(item => {
              _this.workshops.push(item)
            });
            if(_this.jsonDataParam.iPage === _this.tempWorkshops.last_page){
              _this.fullData = true
            }
          } else {
            this.jsonDataParam.iPage = this.jsonDataParam.iPage - 1
            console.log(this.jsonDataParam.iPage)
          }
          // _this.doLoopForFilter(_this.workshops.data)
          _this.loader = false
        }) .catch((err) =>{
          console.log(err)
          _this.loader = false
        })
    },
    // loadNextPage () {
    //   let custList = document.getElementsByClassName("q-scrollarea__container")[0]
    //     let custListScrollTillBottom = custList.scrollHeight - custList.clientHeight 
    //     if (custListScrollTillBottom <= custList.scrollTop) {
    //       if (this.jsonDataParamCustomer.iPage < this.jsonDataParamCustomer.maxPage && !this.loaderCustomer) {
    //         this.loaderCustomer = true
    //         this.jsonDataParamCustomer.iPage++
    //         this.jsonDataParamCustomer.keyword = ''
    //         this.doGetMerchantCustomerV2(false)
    //         setTimeout(() => {
    //             custList.scrollTop = custList.scrollTop - 5
    //         }, 500)
    //       }
    //     }
    //   }
    // },
    doConsole(a){
      console.log(a);
    }
  }
}
</script>