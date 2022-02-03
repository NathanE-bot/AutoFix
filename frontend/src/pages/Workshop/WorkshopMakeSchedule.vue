<template>
    <q-page class="bg-white form-schedule">
        <div class="topInfo">
          <img class="responsive_img fit-content detail-workshop-bg my-30" width="120" src="~assets/images/logo/workshop/honda.png" alt="">
          <div class="detailInfo">
            <span class="text-h6 fw-semibold">{{ workshopDetail.workshopName }}</span>
            <span class="grey-txt">{{ workshopDetail.district }}, {{ workshopDetail.city }}</span>
            <span class="grey-txt mb-20">Rating: {{ workshopDetail.rating }}</span>
            <p>{{ workshopDetail.workshopDescription }}</p>
          </div>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <div class="modelServisFragment">
          <div class="d-flex a-center j-sp-between text-h4 fw-lightbold my-30">
            <span class="fw-semibold">Model & type of service</span>
            <span class="accent_color">1 / 2</span>
          </div>
          <div class="d-flex flex-dir-col">
            <q-select
              @update:model-value="doFilterCarType($event)"
              v-model="jsonDataParam.carModel"
              :options="carModelOptions"
              outlined
              class="br-10px default-select-2 mb-15 w-25"
            >
              <template v-slot:selected>
                <template v-if="jsonDataParam.carModel">
                  {{ jsonDataParam.carModel }}
                </template>
                <template v-else>
                  <span class="placeholder-text">Choose Car Model...</span>
                </template>
              </template>
            </q-select>
            <q-select
              @update:model-value="doGetCarServices($event)"
              v-model="jsonDataParam.carType"
              :options="carTypeOptions"
              outlined
              class="br-10px default-select-2 mt-15 w-25"
            >
              <template v-slot:selected>
                <template v-if="jsonDataParam.carType">
                  {{ jsonDataParam.carType }}
                </template>
                <template v-else>
                  <span class="placeholder-text">Choose Car Type...</span>
                </template>
              </template>
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    Please choose car model first.
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
          <div class="my-20">
            <span class="text-h5">Select the services required for your car</span>
          </div>
          <div class="w-90 mx-auto">
            <q-card class="br-10px mb-30 grey-1bg card-shadow-1">
              <q-card-section>
                <q-checkbox v-model="periodic" :disable="help.isDataEmpty(jsonDataParam.carType)" color="secondary" label="Periodic Services" :class="['fw-lightbold fs-20']">
                  <q-tooltip transition-show="scale" transition-hide="scale" v-if="help.isDataEmpty(jsonDataParam.carType)">
                    Choose car model and type first
                  </q-tooltip>
                </q-checkbox>
                <div v-if="periodic" class="py-20 q-pa-md">
                  <div class="q-gutter-y-lg">
                    <q-select
                      @update:model-value="doCalculateTotalPriceAndHour()"
                      v-model="tempPeriodicService"
                      :options="periodicServicesOptions"
                      option-value="price"
                      option-label="serviceDetail"
                      outlined input-debounce="0"
                      class="br-10px default-select-2 mt-15 w-25"
                    >
                      <template v-slot:append>
                        <q-icon
                          v-if="tempPeriodicService !== null"
                          class="cursor-pointer"
                          name="clear"
                          @click.stop="tempPeriodicService = null; doCalculateTotalPriceAndHour()"
                        />
                      </template>
                      <template v-slot:selected>
                        <template v-if="tempPeriodicService">
                          {{ tempPeriodicService.serviceDetail }}
                        </template>
                        <template v-else>
                          <span class="placeholder-text">Choose periodic service...</span>
                        </template>
                      </template>
                      <template v-slot:no-option>
                        <q-item>
                          <q-item-section class="text-grey">
                            {{ help.isObjectEmpty(periodicServicesOptions) ? 'No available services.' : 'Please choose car type first.' }}
                          </q-item-section>
                        </q-item>
                      </template>
                    </q-select>
                  </div>
                </div>
              </q-card-section>
              <q-card-section>
                <q-checkbox v-model="general" :disable="help.isDataEmpty(jsonDataParam.carType)" color="secondary" label="General Services" :class="['fw-lightbold fs-20']">
                  <q-tooltip transition-show="scale" transition-hide="scale" v-if="help.isDataEmpty(jsonDataParam.carType)">
                    Choose car model and type first
                  </q-tooltip>
                </q-checkbox>
                <div v-if="general">
                  <div class="row q-col-gutter-y-xl" style="gap: 5%" v-if="!help.isObjectEmpty(generalServicesOptions)">
                    <div class="col-md-3 w-30-i" v-for="service in generalServicesOptions" :key="service.id">
                      <div class="general-services">
                        <q-checkbox v-model="service.checked" @update:model-value="doCalculateTotalPriceAndHour()" size="xs" />
                        <div class="content">
                          <span>{{ service.serviceDetail }}</span>
                          <span>{{ service.price }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-else class="grey-txt p-10">
                    Please Choose Car Type First.
                  </div>
                </div>
              </q-card-section>
            </q-card>
            <q-card class="br-10px w-70 grey-1bg card-shadow-1">
              <q-card-section class="pl-30 pr-30">
                <div class="my-20">
                  <span>Car Damage / Service Request. (Optional)</span>
                </div>
                <q-input
                  v-model="jsonDataParam.description"
                  outlined counter maxlength="500"
                  type="textarea"
                  class="fix-txt-field default-textarea-1"
                >
                </q-input>
              </q-card-section>
            </q-card>
            <div class="row my-40 estimation-section">
              <q-card class="my-card l-card col-md-4">
                <q-card-section>
                  <div class="text-align-right">
                    <is-estimation-price class="svg-grey1" />
                  </div>
                  <div class="text-section">
                    <div class="text-h4 fw-semibold">{{ jsonDataParam.priceEstimation == 0 ? 'Rp. ' + 0 : ValidationFunction.convertToRupiah(jsonDataParam.priceEstimation) }}</div>
                    <div class="text-h6">Estimation Services Price</div>
                    <div class="text-subtitle2 grey-txt">*Prices above are estimated service costs without additional work. Prices may vary, depending on the type of car & tax conditions.</div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="my-card r-card col-md-4">
                <q-card-section>
                  <div class="text-align-right">
                    <is-estimation-hour class="svg-grey1" />
                  </div>
                  <div class="text-section">
                    <div class="text-h4 fw-semibold">{{ jsonDataParam.timeEstimation == 0 ? 0 : jsonDataParam.timeEstimation }} Hour</div>
                    <div class="text-h6">Estimation Services Duration</div>
                    <div class="text-subtitle2 grey-txt">*Note it can be varied and it's just an estimation.</div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
            <q-btn
              @click="secondPage = true"
              :disable="(help.isObjectEmpty(jsonDataParam.serviceTypeBerkala) || this.jsonDataParam.serviceTypeBerkala[0] === null) && help.isObjectEmpty(jsonDataParam.serviceTypeUmum)"
              outline color="primary"
              label="Continue"
              class="tf-capitalize fw-bold w-30 fs-30 br-10px mb-20 default-btn-1"
            >
            </q-btn>
          </div>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <q-slide-transition class="w-95 m-auto">
          <div v-show="secondPage">
            <div class="d-flex a-center j-sp-between text-h4 fw-lightbold my-30">
              <span class="fw-semibold">Choose schedule date & time</span>
              <span class="accent_color">2 / 2</span>
            </div>
            <div class="d-flex a-baseline mb-30">
              <div class="d-flex flex-dir-col mr-30 w-60">
                <span class="grey-txt text-h6 fw-semibold mb-10">Choose Date</span>
                <q-date class="schedule-date fw" color="accent" v-model="jsonDataParam.scheduleDateTemp" :options="(date) => date >= help.formatToday(help.data().dmy_3)" />
              </div>
              <div class="d-flex flex-dir-col">
                <span class="grey-txt text-h6 fw-semibold mb-10">Choose Time</span>
                <q-time
                  v-model="jsonDataParam.scheduleTime"
                  class="schedule-time fw" color="accent"
                  landscape
                />
              </div>
            </div>
            <q-btn
              @click="doMakeSchedule()"
              :disable="help.isObjectEmpty(jsonDataParam.scheduleTime) || help.isObjectEmpty(jsonDataParam.scheduleDateTemp)"
              outline color="primary"
              label="Make Schedule"
              class="tf-capitalize fw-bold w-30 fs-30 br-10px mb-20 default-btn-1"
            >
            </q-btn>
          </div>
        </q-slide-transition>
    </q-page>
</template>

<script>
/* eslint-disable */
// SVGs
import isvgEstHour from '../../components/IconSVG/isvg_estimated_hour'
import isvgEstPrice from '../../components/IconSVG/isvg_estimated_price'
// End Of SVGs
import ValidationFunction from '../../js/ValidationFunction'
import help from '../../js/help'
import { getWorkshopById } from '../../api/workshopService'
import { makeSchedule } from '../..//api/ScheduleService'
import { LocalStorage } from 'quasar'
import Swal from 'sweetalert2'

export default {
  components: {
    isEstimationHour: isvgEstHour,
    isEstimationPrice: isvgEstPrice,
    ValidationFunction
  },
  data () {
    return {
      help,
      ValidationFunction,
      secondPage: false,
      workshopId: null,
      tempPeriodicService: null,
      workshopDetail: [],
      workshop_details: [],
      carModelOptions: [],
      carTypeOptions: [],
      tempCarTypeOptions: [],
      periodicServicesOptions: [],
      generalServicesOptions: [],
      jsonDataParam: {
        workshopID: null,
        userID: null,
        carModel: null,
        carType: null,
        serviceTypeBerkala: [],
        serviceTypeUmum: [],
        description: null,
        timeEstimation: 0,
        priceEstimation: 0,
        scheduleDate: null,
        scheduleTime: null,
        scheduleDateTemp: help.formatTommorow(help.data().dmy_3)
      },
      periodic: false,
      general: false
    }
  },
  created () {
    this.workshopId = parseInt(this.$route.params.id)
    if(!help.isDataEmpty(this.workshopId)){
      this.doGetWorkshopById()
    }
  },
  methods: {
    doGetWorkshopById () {
      let _this = this
      getWorkshopById(_this.workshopId).then(response => {
        _this.loader = true
        _this.workshopDetail = response.data
        // loopingan data servis
        _this.workshopDetail.workshop_details.forEach(el1 => {
            let tempArr = []
            //for car model option
            let tempString1 = ""
            tempString1 = el1.carModel
            _this.carModelOptions.push(tempString1)

            //for car type option
            let tempObj = {
              carModel: el1.carModel,
              carType: el1.carType
            }
            _this.tempCarTypeOptions.push(tempObj)
          _this.workshopDetail.workshop_services.forEach(el2 =>{
            if(el2.workshopDetailID === el1.id){
              tempArr.push(el2)
            }
          })

          let tempObject = {
            id: el1.id,
            workshopId: el1.workshopID,
            carModel: el1.carModel,
            carType: el1.carType,
            workshop_services: tempArr,
            created_at: el1.created_at,
            updated_at: el1.updated_at,
          }
          _this.workshop_details.push(tempObject)
        })
        _this.carModelOptions = ValidationFunction.arrayFilterWithSet(_this.carModelOptions)
        _this.loader = false
      }).catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    doClearData () {
      this.carTypeOptions = []
      this.generalServicesOptions = []
      this.jsonDataParam.carType = null
      this.tempPeriodicService = null
      this.periodicServicesOptions = []
      this.periodic = false
      this.general = false
    },
    doFilterCarType (val) {
      this.doClearData()
      let tempArr = []
      const needle = val.toLocaleLowerCase()
      tempArr = this.tempCarTypeOptions.filter(v => v.carModel.toLocaleLowerCase().indexOf(needle) > -1)
      tempArr.forEach(el1 => {
        let tempString = ""
        tempString = el1.carType
        this.carTypeOptions.push(tempString)
      })
      this.doCalculateTotalPriceAndHour()
    },
    doGetCarServices(val){
      // get car model n type id
      this.generalServicesOptions = []
      let selectedCarType = []
      const needle1 = val.toLocaleLowerCase()
      selectedCarType = this.workshopDetail.workshop_details.filter(v => v.carType.toLocaleLowerCase().indexOf(needle1) > -1)[0]

      // get services by model n type id and separate services by type
      let tempArrServices = []
      const needle2 = selectedCarType.id
      let tempArrPeriodic = []
      let tempArrGeneral = []

      tempArrServices = this.workshopDetail.workshop_services.filter(v => v.workshopDetailID == needle2)
      // Periodic
      tempArrPeriodic = tempArrServices.filter(v => v.serviceType.toLocaleLowerCase().indexOf('servis berkala') > -1)
      tempArrPeriodic.forEach(el1 => {
        let tempObj = {
          serviceDetail: el1.serviceDetail,
          price: el1.price,
          time: el1.time
        }
        this.periodicServicesOptions.push(tempObj)
      })
      // General
      tempArrGeneral = tempArrServices.filter(v => v.serviceType.toLocaleLowerCase().indexOf('servis umum') > -1)
      tempArrGeneral.forEach(el1 => {
        let tempObj1 = {
          serviceDetail: el1.serviceDetail,
          price: el1.price,
          time: el1.time,
          checked: false
        }
        this.generalServicesOptions.push(tempObj1)
      })
      this.doCalculateTotalPriceAndHour()
    },
    doFilterDataSchedule () {
      this.jsonDataParam.timeEstimation = 0
      this.jsonDataParam.priceEstimation = 0
      this.jsonDataParam.serviceTypeUmum = []
      this.jsonDataParam.serviceTypeBerkala = []
    },
    doCalculateTotalPriceAndHour () {
      setTimeout(() => {
        this.doFilterDataSchedule()
        if(!help.isDataEmpty(this.tempPeriodicService)){
          this.jsonDataParam.serviceTypeBerkala.push(this.tempPeriodicService)
        }
        // for periodic
        if(!help.isObjectEmpty(this.jsonDataParam.serviceTypeBerkala) && this.jsonDataParam.serviceTypeBerkala[0] !== null){
          this.jsonDataParam.timeEstimation = this.jsonDataParam.timeEstimation + this.tempPeriodicService.time
          this.jsonDataParam.priceEstimation = this.jsonDataParam.priceEstimation + this.tempPeriodicService.price
        }

        // for general
        this.generalServicesOptions.forEach(el1 => {
          if(el1.checked){
            this.jsonDataParam.serviceTypeUmum.push(el1)
            this.jsonDataParam.timeEstimation = this.jsonDataParam.timeEstimation + el1.time
            this.jsonDataParam.priceEstimation = this.jsonDataParam.priceEstimation + el1.price
          }
        })
      }, 0)
    },
    doMakeSchedule () {
      let _this = this
      _this.loader = true
      _this.jsonDataParam.workshopID = _this.workshopId
      if(!help.isDataEmpty(LocalStorage.getItem('autoRepairUser').data.user.id)){
        _this.jsonDataParam.userID = LocalStorage.getItem('autoRepairUser').data.user.id
      }
      _this.jsonDataParam.scheduleDate = help.defaultFormat(_this.jsonDataParam.scheduleDateTemp, help.data().dmy_5)
      let token = LocalStorage.getItem('autoRepairUser').data.access_token
      console.log(_this.jsonDataParam)
      makeSchedule(_this.jsonDataParam, token).then(response => {
        _this.loader = false
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Schedule created successfully'
        }) .then((result) => {
          if(result.isConfirmed){
            // MSH BELUM BENAR
            this.changePage('/member/schedule-list')
          }
        })
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    changePage (url) {
      this.$router.push(url)
    },
    doConsole(a){
      console.log(a)
    }
  }
}
</script>
