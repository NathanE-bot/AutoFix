<template>
    <q-page class="bg-white form-schedule">
        <div class="topInfo">
          <img class="responsive_img detail-workshop-bg my-30" width="120" src="~assets/images/logo/workshop/honda.png" alt="">
          <div class="detailInfo">
            <span class="text-h6 fw-semibold">{{ workshopDetail.workshopName }}</span>
            <span class="grey-txt">{{ workshopDetail.district }}, {{ workshopDetail.city }}</span>
            <span class="grey-txt mb-20">Rating: {{ workshopDetail.rating }}</span>
            <p>{{ workshopDetail.workshopDescription }}</p>
          </div>
        </div>
        <q-separator class="br-5px" color="#605A5A" size="4px" />
        <div class="modelServisFragment" v-if="isShown === false">
          <div class="d-flex a-center j-sp-between text-h4 fw-lightbold my-30">
            <span>Model & type of service</span>
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
            <q-card class="br-10px mb-30">
              <q-card-section>
                <q-checkbox v-model="periodic" :disable="help.isDataEmpty(jsonDataParam.carType)" color="secondary" label="Periodic Services" :class="['fw-lightbold fs-20']">
                  <q-tooltip transition-show="scale" transition-hide="scale" v-if="help.isDataEmpty(jsonDataParam.carType)">
                    Choose car model and type first
                  </q-tooltip>
                </q-checkbox>
                <div v-if="periodic" class="py-20 q-pa-md">
                  <div class="q-gutter-y-lg">
                    <q-select
                      @update:model-value="doConsole($event)"
                      v-model="jsonDataParam.periodicService"
                      :options="periodicServicesOptions"
                      outlined
                      class="br-10px default-select-2 mt-15 w-25"
                    >
                      <template v-slot:selected>
                        <template v-if="jsonDataParam.periodicService">
                          {{ jsonDataParam.periodicService.label }}
                        </template>
                        <template v-else>
                          <span class="placeholder-text">Choose periodic service...</span>
                        </template>
                      </template>
                      <template v-slot:no-option>
                        <q-item>
                          <q-item-section class="text-grey">
                            Please choose car type first.
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
                        <q-checkbox v-model="service.checked" size="xs" />
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
            <q-card class="br-10px w-50">
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
            <div class="d-flex a-center my-40 estimation-section">
              <q-card class="my-card l-card">
                <q-card-section>
                  <div class="text-align-right">
                    <is-estimation-price class="svg-grey1" />
                  </div>
                  <div class="text-section">
                    <div class="text-h4 fw-semibold">Rp. 0</div>
                    <div class="text-h6">Estimation Price Services</div>
                    <div class="text-subtitle2 grey-txt">*Prices above are estimated service costs without additional work. Prices may vary, depending on the type of car & tax conditions.</div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="my-card r-card">
                <q-card-section>
                  <div class="text-align-right">
                    <is-estimation-hour class="svg-grey1" />
                  </div>
                  <div class="text-section">
                    <div class="text-h4 fw-semibold">0 Hour</div>
                    <div class="text-h6">Estimation Service Duration</div>
                    <div class="text-subtitle2 grey-txt">*Note it can be varied and it's just an estimation.</div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
            <q-btn
              outline color="primary"
              label="Continue"
              class="tf-capitalize fw-bold w-20 fs-30 br-10px mb-20 default-btn-1"
            >
            </q-btn>
          </div>
        </div>
        <div v-else>
          <q-btn @click="isShown = !isShown" label="Kembali" color="secondary"/>
          <div>
            <!-- :options="dateValidation.minimalDateFromToday(help.formatToday(help.data().dmy_3))" -->
            <q-date
              v-model="date"
              minimal
              landscape
            />
          </div>
          tampilan 2
          <q-btn label="Submit" color="primary"/>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
// SVGs
import isvgEstHour from '../../components/IconSVG/isvg_estimated_hour'
import isvgEstPrice from '../../components/IconSVG/isvg_estimated_price'
// End Of SVGs
import dateValidation from '../../js/dateValidation'
import help from '../../js/help'
import { getWorkshopById } from '../../api/workshopService'
export default {
  components: {
    isEstimationHour: isvgEstHour,
    isEstimationPrice: isvgEstPrice
  },
  data () {
    return {
      help,
      dateValidation,
      workshopId: null,
      workshopDetail: [],
      workshop_details: [],
      carModelOptions: [],
      tempCarTypeOptions: [],
      periodicServicesOptions: [],
      generalServicesOptions: [],
      carTypeOptions: [],
      jsonDataParam: {
        carModel: null,
        carType: null,
        periodicService: null,
        description: null
      },
      detail: {
        namaBengkel: '',
        kabupaten: '',
        rating: 0,
        deskripsiBengkel: ''
      },
      isShown: false,
      checkbox1: false,
      checkbox2: false,
      disablePage2: false,
      periodic: false,
      general: false,
      optionsCheckbox1: [
        { label: '1', value: '1' },
        { label: '2', value: '2' },
        { label: '3', value: '3' },
        { label: '4', value: '4' }
      ]
    }
  },
  created () {
    this.workshopId = this.$route.params.id
    if(!help.isDataEmpty(this.workshopId)){
      this.doGetWorkshopById()
    }
  },
  methods: {
    doGetWorkshopById () {
      let _this = this
      _this.loader = true
      getWorkshopById(_this.workshopId).then(response => {
        _this.workshopDetail = response.data
        // _this.doGetUserWorkshopByWorkshopId(_this.workshopDetail.userID)
        // _this.doGetCurrentPosition()
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
    doFilterCarType (val) {
      this.carTypeOptions = []
      let tempArr = []
      const needle = val.toLocaleLowerCase()
      tempArr = this.tempCarTypeOptions.filter(v => v.carModel.toLocaleLowerCase().indexOf(needle) > -1)
      tempArr.forEach(el1 => {
        let tempString = ""
        tempString = el1.carType
        this.carTypeOptions.push(tempString)
      })
    },
    doGetCarServices(val){
      // get car model n type id
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
      console.log('a', tempArrPeriodic)
      tempArrPeriodic.forEach(el1 => {
        let tempObj = {
          label: el1.serviceDetail,
          price: el1.price
        }
        // let tempString = ""
        // tempString = el1.serviceDetail
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
    },
    doConsole(a){
      console.log(a)
    }
  }
}
</script>
