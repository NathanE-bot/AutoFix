<template>
    <q-page>
        <div class="w-80 m-auto">
            <div class="text-h5 fw-semibold py-20 txt-white" style="border-bottom: 1px solid #3b3b3b">History Order</div>
        </div>
        <div class="w-80 m-auto py-20" v-if="!help.isObjectEmpty(listHistory)">
            <q-scroll-area
            :thumb-style="thumbStyle"
            :bar-style="barStyle"
            class="list-workshop-scrollbar h-80"
            :style="{height: window.heightAltered + 'px'}">
                <q-card v-for="history in listHistory" :key="history.scheduleID" class="adminWorkshop-card w-80 br-10px-i">
                    <q-card-section >
                        <div class="flex flex-center j-sp-between mb-10">
                            <div class="fw-semibold p-10">
                                <span>{{ history.fullName}}</span>
                            </div>
                            <div>
                                <q-badge class="tf-capitalize mr-10 p-5" color="primary" text-color="#ffffff" :label="history.scheduleStatus" />
                            </div>
                        </div>
                        <q-separator/>
                        <q-card-section class="flex m-auto">
                            <div class="w-40">
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Tanggal dan Waktu</span>
                                    <span>{{ help.defaultFormat(history.scheduleDate, help.data().dmy_8) }}</span>
                                    <span>{{ help.formatTime(history.scheduleTime, help.data().time_2) }}</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Model dan Tipe Mobil</span>
                                    <span>{{ history.carModel}} {{ history.carType }}</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Estimasi waktu pengerjaan</span>
                                    <span> {{ history.timeEstimation}} Jam</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Estimasi Harga</span>
                                    <span>{{ validationFunction.convertToRupiah(history.priceEstimation) }}</span>
                                </div>
                            </div>
                            <div class="w-60">
                                <span class="fw-semibold">Layanan yang dipilih : </span>
                                <div v-if="Object.keys(history.serviceDetail.periodicServices).length !== 0" class="flex flex-dir-col mb-10 ml-5">
                                    <span class="fw-semibold">Periodic Service :</span>
                                    <span>{{ history.serviceDetail.periodicServices.serviceDetail }}</span>
                                </div>
                                <div v-if="history.serviceDetail.generalServices.length !== 0" class="ml-5">
                                    <span class="fw-semibold">General Services: </span><br>
                                    <div>
                                        <span class="flex flex-dir-col" v-for="service in history.serviceDetail.generalServices" :key="service.id">
                                            - {{ service.serviceDetail}}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="history.serviceDescription !== null">
                                <span class="fw-semibold">Service Request: </span>
                                <p class="m-0">{{ history.serviceDescription }}</p>
                            </div>
                        </q-card-section>
                    </q-card-section>
                </q-card>
            </q-scroll-area>
        </div>
        <div v-else class="w-80 m-auto py-20 text-align-center txt-white">
            No Data
        </div>
    </q-page>
</template>

<script>
/*eslint-disable*/
import { getScheduleHistoryByAdmin } from '../../../api/AdminWorkshopServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'
import validationFunction from '../../../js/ValidationFunction'
import Swal from 'sweetalert2'

export default {
  data () {
    return {
        help,
        Swal,
        validationFunction,
        user: {},
        loader: false,
        listHistory: [],
        window: {
            width: 0,
            height: 0,
            heightAltered: 0
        },
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
        }
      }
    },
    created() {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doGetScheduleHistoryByAdmin()
    },
    mounted () {
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
        this.window.heightAltered = window.innerHeight - (window.innerHeight * (35/100))
      },
      doGetScheduleHistoryByAdmin(){
        this.loader = true
        this.listHistory = []
        getScheduleHistoryByAdmin(this.user.id).then(response => {
          console.log(response.data)
          let tempListHistory = []
          let tempListServiceDetails = []
          let tempListDataCustomer = {}

          tempListHistory = response.data.listSchedule
          tempListServiceDetails = response.data.listDetails
          tempListDataCustomer = response.data.listDataCustomer

          if(!help.isObjectEmpty(tempListHistory)){
            tempListHistory.forEach(el1 =>{
              let tempObject = {
                serviceDetail: {
                  periodicServices: {},
                  generalServices: []
                }
              }

              tempListServiceDetails.forEach(el2 => {
                if(el2.scheduleID === el1.scheduleID){
                  if(el2.serviceType === 'servis umum'){
                    tempObject.serviceDetail.generalServices.push(el2)
                  }else{
                    tempObject.serviceDetail.periodicServices = el2
                  }
                }
              })

              let tempObjectCustomer = {
                customerID: null,
                fullName: '',
                phoneNumber: ''
              }

              tempListDataCustomer.forEach(el2 => {
                if(el1.customerID === el2.customerID){
                  tempObjectCustomer = el2
                }
              })

              console.log('tempListDataCustomer',tempListDataCustomer)
              tempObject = { ...tempObject, ...el1, ...tempObjectCustomer }
              this.listHistory.push(tempObject)
            })

            console.log('history', this.listHistory)
          }
        })
        this.loader = true
      }
    }
}
</script>