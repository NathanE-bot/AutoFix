<template>
  <q-page-container style="padding-top: 1.25rem;">
    <q-page class="w-90 m-auto fh p-20">
      <div class="white-1bg fh br-20px">
        <q-tabs
          v-model="initialTab"
          align="justify"
        >
          <q-tab name="editWorkshop" label="Edit Workshop" class="tf-capitalize"/>
          <q-tab name="editServices" label="Edit Services" class="tf-capitalize"/>
        </q-tabs>
        <q-separator/>
        <div v-if="initialTab === 'editWorkshop'" class="col-md-12 p-20">
          <div class="row j-end px-20 pt-10">
            <div v-if="isEditableWorkshop === false" style="height: 31px">
              <i class="fas fa-pen fs-20 edit-icon" @click="isEditableWorkshop = !isEditableWorkshop"></i>
              <q-tooltip class="bg-primary text-body2 txt-white" self="center right" :offset="[10, 15]">
                Edit Profile
              </q-tooltip>
            </div>
            <div v-else>
              <q-btn
                v-if="isEditableWorkshop"
                @click="doCancelEdit(); isEditableWorkshop = !isEditableWorkshop" :loading="loader" unelevated rounded color="negative" label="Cancel Edit" class="tf-capitalize ml-20 fs-12"/>
              <q-btn
                v-if="isEditableWorkshop"
                @click="doUpdateProfile(true)" :loading="loader" unelevated rounded color="primary" label="Save Profile" class="tf-capitalize ml-20 fs-12"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div :class="['no-logo-layout-4 m-auto', { 'm-auto' : help.isDataEmpty(this.dataWorkshop.workshopLogo) && loader === false }]">
                <img  v-if="!help.isDataEmpty(this.dataWorkshop.workshopLogo)" class="m-auto" src="https://cdn.quasar.dev/img/mountains.jpg" alt="">
                <span>No Logo</span>
              </div>
            </div>
            <div class="col-md-3 px-10 q-col-gutter-y-sm">
              <div class="fs-12">
                <span class="">Workshop Name :</span>
                <q-input  v-model="this.dataWorkshop.workshopName" dense outlined :disable="isEditableWorkshop === false"/>
              </div>
              <div class="fs-12">
                <span class="">Workshop Email :</span>
                <q-input v-model="this.dataWorkshop.workshopEmail" dense outlined disable/>
              </div>
              <div class="fs-12">
                <span class="">Workshop Phone Number :</span>
                <q-input v-model="this.dataWorkshop.workshopPhoneNumber" dense outlined :disable="isEditableWorkshop === false"/>
              </div>
            </div>
            <div class="col-md-3 px-10 q-col-gutter-y-sm">
              <div class="fs-12">
                <span class="">District :</span>
                <q-input  v-model="this.dataWorkshop.district" dense outlined :disable="isEditableWorkshop === false"/>
              </div>
              <div class="fs-12">
                <span class="">City :</span>
                <q-input v-model="this.dataWorkshop.city" dense outlined :disable="isEditableWorkshop === false"/>
              </div>
              <div class="fs-12">
                <span class="">Province :</span>
                <q-input v-model="this.dataWorkshop.province" dense outlined :disable="isEditableWorkshop === false"/>
              </div>
            </div>
            <div class="col-md-3 px-10 q-col-gutter-y-sm">
              <div class="fs-12">
                <span class="">Latitude :</span>
                <q-input v-model="this.dataWorkshop.latitude" dense outlined :disable="isEditableWorkshop === false"/>
              </div>
              <div class="fs-12">
                <span class="">Longitude :</span>
                <q-input v-model="this.dataWorkshop.longitude" dense outlined :disable="isEditableWorkshop === false"/>
              </div>
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-6 pr-10">
              <div class="fs-12">
                <span class="">Workshop Address :</span>
                <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="this.dataWorkshop.workshopAddress" outlined type="textarea" :disable="isEditableWorkshop === false"/>
              </div>
            </div>
            <div class="col-md-6 pl-10">
              <div class="fs-12">
                <span class="">Workshop Description :</span>
                <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="this.dataWorkshop.workshopDescription" outlined type="textarea" :disable="isEditableWorkshop === false"/>
              </div>
            </div>
          </div>
        </div>
        <div v-if="initialTab === 'editServices'" class="col-md-12">
          <div class="row">
            <div class="col-md-4 p-20">
              <div class="col-12 j-end">
                <i class="fas fa-pen fs-20 edit-icon" @click="doOpenEditModelAndType()" ></i>
                <q-tooltip class="bg-primary text-body2 txt-white" anchor="center left" self="center left" :offset="[-150, 0]">
                  Edit Car Model & Type
                </q-tooltip>
              </div>
              <br/>
              <q-select
                @update:model-value="doFilterCarType($event)"
                v-model="dataWorkshop.carModel"
                :options="listCarModel"
                outlined
                class="br-10px default-select-2 w-80 mx-auto mb-20"
              >
                <template v-slot:selected>
                  <template v-if="dataWorkshop.carModel">
                    {{ dataWorkshop.carModel }}
                  </template>
                  <template v-else>
                    <span class="placeholder-text">Choose Car Model...</span>
                  </template>
                </template>
              </q-select>
              <q-select
                @update:model-value="doGetCarServices($event)"
                v-model="dataWorkshop.carType"
                :options="listCarType"
                outlined
                class="br-10px default-select-2 w-80 mx-auto mb-20"
              >
                <template v-slot:selected>
                  <template v-if="dataWorkshop.carType">
                    {{ dataWorkshop.carType }}
                  </template>
                  <template v-else>
                    <span class="placeholder-text">Choose Car Type...</span>
                  </template>
                </template>
              </q-select>
            </div>
            <q-separator vertical />
            <div class="col-md-7 p-20">
              <div class="col-12 j-end">
                <i class="fas fa-pen fs-20 edit-icon" @click="doOpenEditServices()" ></i>
                <q-tooltip class="bg-primary text-body2 txt-white" anchor="center left" self="center left" :offset="[-150, 0]">
                  Edit Periodic and General Services
                </q-tooltip>
              </div>
              <div class="row">
                <q-checkbox v-model="periodic" :disable="help.isDataEmpty(dataWorkshop.carType)" color="secondary" label="Periodic Services" :class="['fw-lightbold fs-20']">
                  <q-tooltip transition-show="scale" transition-hide="scale" v-if="help.isDataEmpty(dataWorkshop.carType)">
                    Choose car model and type first
                  </q-tooltip>
                </q-checkbox>
                <div class="row col-12 ml-40 mt-10 gap-1" v-if="periodic">
                  <div class="auto-3" v-for="service in periodicServicesOptions" :key="service.id">
                    <span>{{ service.serviceDetail }} - Rp {{ ValidationFunction.convertToRupiah(service.price) }}</span>
                  </div>
                </div>
              </div>
              <br/>
              <div class="row">
                <q-checkbox v-model="general" :disable="help.isDataEmpty(dataWorkshop.carType)" color="secondary" label="General Services" :class="['fw-lightbold fs-20']">
                  <q-tooltip transition-show="scale" transition-hide="scale" v-if="help.isDataEmpty(dataWorkshop.carType)">
                    Choose car model and type first
                  </q-tooltip>
                </q-checkbox>
                <div class="row col-12 ml-40 mt-10 gap-1" v-if="general">
                  <div class="auto-3" v-for="service in generalServicesOptions" :key="service.id">
                    <span>{{ service.serviceDetail }} - Rp {{ ValidationFunction.convertToRupiah(service.price) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <q-dialog v-model="promptEditModelAndType" persistent>
        <q-card style="min-width: 20rem" class="p-20" >
          <q-card-section>
            <div style="overflow-y:auto; max-height: 35rem;" class="p-20">
              <table class="fw m-auto table-sticky">
                <thead class="fw-semibold sticky">
                  <tr>
                    <td>No</td>
                    <td>Car Model</td>
                    <td>Car Type</td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(detail, index) in tempUpdateModelAndType" :key="detail.id">
                    <td>{{ index+1 }}</td>
                    <td>
                      <q-input v-model="detail.carModel"/>
                    </td>
                    <td>
                      <q-input v-model="detail.carType"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </q-card-section>
          <q-card-actions align="center" class="text-primary">
              <q-btn label="Cancel" v-close-popup @click="doGetWorkshopDetailByUserID()"/>
              <q-btn color="primary" label="Submit" v-close-popup @click="doUpdateProfile(true)"/>
          </q-card-actions>
        </q-card>
      </q-dialog>
      <q-dialog v-model="promptEditServices">
        <q-card style="min-width: 480px" class="p-20" >
          <div style=" max-height: 35rem;">
            <div style="overflow-y:auto;">
              Periodic Services
              <table class="fw m-auto table-sticky">
                <thead class="fw-semibold sticky">
                  <tr>
                    <td>No</td>
                    <td>Service Detail</td>
                    <td>Service Price</td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(detail, index) in tempUpdateServices.periodic_serivces" :key="detail.id">
                    <td>{{ index+1 }}</td>
                    <td>
                      <q-input v-model="detail.serviceDetail"/>
                    </td>
                    <td>
                      <q-input v-model="detail.price"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div style="overflow-y:auto;">
              General Services
              <table class="fw m-auto table-sticky">
                <thead class="fw-semibold sticky">
                  <tr>
                    <td>No</td>
                    <td>Service Detail</td>
                    <td>Service Price</td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(detail, index) in tempUpdateServices.general_services" :key="detail.id">
                    <td>{{ index+1 }}</td>
                    <td>
                      <q-input v-model="detail.serviceDetail"/>
                    </td>
                    <td>
                      <q-input v-model="detail.price"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div align="center" class="text-primary">
              <q-btn label="Cancel" v-close-popup  @click="promptEditServices = false; doGetWorkshopDetailByUserID()"/>
              <q-btn color="primary" label="Done" v-close-popup @click="doHandleIncomingOrder('accept', '')"/>
          </div>
        </q-card>
      </q-dialog>
    </q-page>
  </q-page-container>
</template>

<script>
import { getWorkshopDetailByUserID, doUpdateWorkshopForAdminBengkel } from '../../../api/AdminWorkshopServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'
import ValidationFunction from '../../../js/ValidationFunction'

export default {
  data () {
    return {
      ValidationFunction,
      loader: false,
      help,
      user: {},
      tempUser: {},
      initialTab: 'editServices',
      dataWorkshop: {},
      tempDataWorkshop: {},
      isEditableWorkshop: false,
      promptEditModelAndType: false,
      promptEditServices: false,
      periodic: false,
      periodicServicesOptions: [],
      general: false,
      generalServicesOptions: [],
      listServices: [],
      listCarModel: [],
      listCarType: [],
      tempListCarType: [], // ini buat apa??
      dataUpdate: {
        workshopID: null,
        userID: null,
        carModel: null
      },
      tempUpdateModelAndType: [],
      tempUpdateServices: {}
    }
  },
  created () {
    this.user = LocalStorage.getItem('autoRepairUser').data.user
    this.doGetWorkshopDetailByUserID()
  },
  methods: {
    doConsole (a) {
      console.log('asd', a)
    },

    // =============================================================Fetch Data========================================================

    doGetWorkshopDetailByUserID () {
      this.loader = true
      getWorkshopDetailByUserID(this.user.id).then(response => {
        console.log('response', response.data)
        this.dataWorkshop = response.data
        this.dataWorkshop.workshopID = this.dataWorkshop.id
        delete this.dataWorkshop.id
        this.doUpdateProfile(false)

        this.dataWorkshop.workshop_details.forEach(l1 => {
          // list car Model
          const tempString = l1.carModel
          this.listCarModel.push(tempString)

          // list car Type
          const tempObj = {
            carModel: l1.carModel,
            carType: l1.carType
          }
          this.tempListCarType.push(tempObj)

          const tempArr = []
          this.dataWorkshop.workshop_services.forEach(l2 => {
            tempArr.push(l2)
          })

          const tempObject = {
            workshopDetailID: l1.workshopID,
            carModel: l1.carModel,
            carType: l1.carType,
            workshop_services: tempArr,
            created_at: l1.created_at,
            updated_at: l1.updated_at
          }

          this.listServices.push(tempObject)
        })
        this.listCarModel = ValidationFunction.arrayFilterCarModel(this.listCarModel)
        this.loader = false
        // console.log('listServices', this.listServices)
        // console.log('listCarModel', this.listCarModel)
      }).catch((err) => {
        console.log(err)
        this.loader = false
      })
    },
    doFilterCarType (val) {
      // this.doClearData()
      this.listCarType = []
      let tempArr = []
      const needle = val.toLocaleLowerCase()
      tempArr = this.tempListCarType.filter(v => v.carModel.toLocaleLowerCase().indexOf(needle) > -1)
      tempArr.forEach(el1 => {
        let tempString = ''
        tempString = el1.carType
        this.listCarType.push(tempString)
      })
      // console.log('options', this.listCarType)
    },
    doGetCarServices (val) {
      // get car model n type id
      this.generalServicesOptions = []
      let selectedCarType = []
      const needle1 = val.toLocaleLowerCase()
      selectedCarType = this.dataWorkshop.workshop_details.filter(v => v.carType.toLocaleLowerCase().indexOf(needle1) > -1)[0]

      // get services by model n type id and separate services by type
      let tempArrServices = []
      const needle2 = selectedCarType.id
      let tempArrPeriodic = []
      let tempArrGeneral = []

      tempArrServices = this.dataWorkshop.workshop_services.filter(v => v.workshopDetailID === needle2)
      // Periodic
      tempArrPeriodic = tempArrServices.filter(v => v.serviceType.toLocaleLowerCase().indexOf('servis berkala') > -1)
      tempArrPeriodic.forEach(el1 => {
        const tempObj = {
          serviceDetail: el1.serviceDetail,
          price: el1.price,
          time: el1.time
        }
        this.periodicServicesOptions.push(tempObj)
      })
      // General
      tempArrGeneral = tempArrServices.filter(v => v.serviceType.toLocaleLowerCase().indexOf('servis umum') > -1)
      tempArrGeneral.forEach(el1 => {
        const tempObj1 = {
          serviceDetail: el1.serviceDetail,
          price: el1.price,
          time: el1.time
        }
        this.generalServicesOptions.push(tempObj1)
      })
      console.log('periodicServicesOptions', this.periodicServicesOptions)
      console.log('generalServicesOptions', this.generalServicesOptions)
    },

    // ==================================================Do Updates===================================================================
    doCancelEdit () {
      this.tempDataWorkshop = []
      this.tempDataWorkshop = this.dataWorkshop
      console.log('cancel', this.dataWorkshop)
      this.doGetWorkshopDetailByUserID()
    },
    doUpdateProfile (update) {
      if (!update) {
        this.tempUser = this.user
        this.tempDataWorkshop = this.dataWorkshop
        // console.log('masuk firstload pak eko', this.tempUser)
      } else {
        console.log('yeet', this.dataWorkshop)
        doUpdateWorkshopForAdminBengkel(this.dataWorkshop).then(response => {
          console.log('response', response)
        })
        console.log('ngapdeeeeeeeet')
      }
      // console.log('njay')
      this.isEditableWorkshop = false
    },
    doOpenEditModelAndType () {
      this.promptEditModelAndType = true
      this.tempUpdateModelAndType = this.dataWorkshop.workshop_details
      console.log('data original', this.dataWorkshop)
      console.log('masuk modal tempUpdateModelAndType', this.tempUpdateModelAndType)
    },
    doOpenEditServices () {
      this.promptEditServices = true
      const tempPeriodicServicesOptions = this.periodicServicesOptions
      const tempGeneralServicesOptions = this.generalServicesOptions
      this.tempUpdateServices = { periodic_serivces: tempPeriodicServicesOptions, general_services: tempGeneralServicesOptions }
      console.log('cek tempUpdateServices List', this.tempUpdateServices)
    }
  }
}
</script>
