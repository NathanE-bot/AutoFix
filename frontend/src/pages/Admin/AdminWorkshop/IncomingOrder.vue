<template>
    <q-page>
        <div class="w-80 m-auto">
            <div class="text-h5 fw-semibold py-20 txt-white">Incoming Order</div>
        </div>
        <div class="white-1bg w-80 m-auto py-20" v-if="!help.isObjectEmpty(listIncoming)">
            <q-card v-for="incoming in listIncoming" :key="incoming.scheduleID" class="adminWorkshop-card w-80">
                <!-- <q-scroll-area
                :thumb-style="thumbStyle"
                :bar-style="barStyle"
                class="list-workshop-scrollbar h-80"> -->
                    <q-card-section >
                        <div class="flex j-sp-between mb-10">
                            <div class="flex flex-center flex-dir-col">
                                <span class="fw-semibold p-10">{{ incoming.fullName}}</span>
                            </div>
                            <div class="flex primary-bg px-15 br-10 br-20px align-item-center txt-white tf-capitalize">
                                {{ incoming.scheduleStatus }}
                            </div>
                        </div>
                        <q-separator/>
                        <q-card-section class="flex m-auto">
                            <div class="w-40">
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Tanggal dan Waktu</span>
                                    <span>{{ help.defaultFormat(incoming.scheduleDate, help.data().dmy_8) }}</span>
                                    <span>{{ help.formatTime(incoming.scheduleTime, help.data().time_2) }}</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Model dan Tipe Mobil</span>
                                    <span>{{ incoming.carModel}} {{ incoming.carType}}</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Estimasi waktu pengerjaan</span>
                                    <span> {{ incoming.timeEstimation}} Jam</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Estimasi Harga</span>
                                    <span>{{ validationFunction.convertToRupiah(incoming.priceEstimation) }}</span>
                                </div>
                            </div>
                            <div class="w-60">
                                <span class="fw-semibold">Layanan yang dipilih : </span>
                                <div v-if="Object.keys(incoming.serviceDetail.periodicService).length !== 0" class="flex flex-dir-col mb-10 ml-5">
                                    <span class="fw-semibold">Periodic Service :</span>
                                    <span>{{ incoming.serviceDetail.periodicService.serviceDetail }}</span>
                                </div>
                                <div v-if="incoming.serviceDetail.generalServices.length !== 0" class="ml-5">
                                    <span class="fw-semibold">General Services: </span><br>
                                    <div>
                                        <span class="flex flex-dir-col" v-for="service in incoming.serviceDetail.generalServices" :key="service.id">
                                            - {{ service.serviceDetail}}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="incoming.serviceDescription !== null">
                                <span class="fw-semibold">Service Request: </span>
                                <p class="m-0">{{ incoming.serviceDescription }}</p>
                            </div>
                        </q-card-section>
                        <div class="d-flex a-center j-end" style="gap: 20px">
                            <q-btn
                                @click="doSetTempScheduleID(incoming.scheduleID, 'reject'); rejectReason = null"
                                color="negative" rounded unelevated padding="4px 24px"
                                label="Reject"
                                class="tf-capitalize"
                            />
                            <q-btn
                                @click="doSetTempScheduleID(incoming.scheduleID, 'accept')"
                                color="primary" rounded unelevated padding="4px 24px"
                                label="Accept"
                                class="tf-capitalize"
                            />
                        </div>
                    </q-card-section>
                <!-- </q-scroll-area> -->
            </q-card>
        </div>
        <div v-else class="white-1bg w-80 m-auto py-20 text-align-center">
            No Data
        </div>
        <q-dialog v-model="promptAccept">
            <q-card style="min-width: 480px" class="py-20" >
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Accept Schedule?</div>
                </q-card-section>

                <q-card-actions align="center" class="text-primary">
                    <q-btn label="Cancel" v-close-popup  @click="promptReject = false"/>
                    <q-btn color="primary" label="Done" v-close-popup @click="doHandleIncomingOrder('accept', '')"/>
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="promptReject">
            <q-card style="min-width: 640px" class="p-16">
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Please insert your reason for Rejecting</div>
                </q-card-section>
                <div class="m-auto">
                    <q-input
                        outlined
                        type="textarea"
                        class="fix-txt-field default-textarea-1 w-80 m-auto"
                        v-model="rejectReason"
                    >
                    </q-input>
                </div>
                <q-card-actions align="right" class="text-primary">
                    <q-btn padding="4px 16px" color="primary" rounded label="Submit" v-close-popup @click="doHandleIncomingOrder('reject',this.rejectReason)"/>
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getIncomingOrderSchedule, doAcceptScheduleByAdmin, doRejectScheduleByAdmin } from '../../../api/AdminWorkshopServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'
import validationFunction from '../../../js/ValidationFunction'
import Swal from 'sweetalert2'
export default {
    data () {
      return {
        help,
        validationFunction,
        user: {},
        listIncoming: [],
        tempManageScheduleID: null,
        rejectReason: null,
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
        },
        promptAccept: false,
        promptReject: false 
      }
    },
    created() {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doGetIncomingOrderSchedule()
    },
    // mounted () {
    //     window.addEventListener('resize', this.handleResize)
    //     this.handleResize()
    // },
    // unmounted () {
    //     window.removeEventListener('resize', this.handleResize)
    // },
    methods: {
        doGetIncomingOrderSchedule() {
            this.loader = true
            this.listIncoming = []
            getIncomingOrderSchedule(this.user.id).then(response => {
                console.log(response)
                let tempListIncoming = []
                let tempListServiceDetails = []
                let tempListDataCustomer = {}
                tempListIncoming = response.data.listSchedule
                tempListServiceDetails = response.data.listDetails
                tempListDataCustomer = response.data.listDataCustomer

                tempListIncoming.forEach(el1 => {
                    let tempObject = {
                        serviceDetail: {
                            periodicService: {},
                            generalServices: []
                        }
                    }

                    let tempObjectCustomer = {
                        customerID: null,
                        fullName: '',
                        phoneNumber: ''
                    }

                    tempListServiceDetails.forEach(el2 => {
                        if(el2.scheduleID === el1.scheduleID){
                            if(el2.serviceType === 'servis umum'){
                                tempObject.serviceDetail.generalServices.push(el2)
                            }else{
                                tempObject.serviceDetail.periodicService = el2
                            }
                        }
                    })

                    tempListDataCustomer.forEach(el2 => {
                        if(el1.customerID === el2.customerID){
                            tempObjectCustomer = el2
                        }
                    })

                    tempObject = { ...tempObject, ...el1, ...tempObjectCustomer}
                    this.listIncoming.push(tempObject)
                })
                console.log('listIncoming',this.listIncoming)
            })

            this.loader = false
        },
        doSetTempScheduleID(scheduleID, action) {
            if(action === 'accept'){
                this.promptAccept = true
            }else{
                this.promptReject = true
            }
            this.tempManageScheduleID = scheduleID
        },
        doHandleIncomingOrder(action, reason) {
            this.loader = true
            if(action === 'accept'){
                doAcceptScheduleByAdmin(this.tempManageScheduleID).then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                    }).then(response => {
                        this.doGetIncomingOrderSchedule()
                    })
                }).catch(err => {
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        title: err.response.data.message
                    }).then(() => {
                        this.loader = false
                    })
                })
                this.promptAccept = false
            }else if(action === 'reject'){
                let submitReject = {}
                submitReject = { scheduleID: this.tempManageScheduleID, description: reason}
                doRejectScheduleByAdmin(submitReject).then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message
                    }).then(response => {
                        this.doGetIncomingOrderSchedule()
                    })
                }).catch(err => {
                    console.log(err)
                    console.log('AAAAAAAAA')
                    Swal.fire({
                        icon: 'error',
                        title: err.response.data.message.description[0]
                    }).then(() => {
                        this.loader = false
                        this.promptReject = false
                    })
                })
                this.promptReject = false
            }
        },
        // doRejectIncomingOrderSchedule(reason) {
        //     let submitReject = {}
        //     submitReject = { scheduleID: this.tempManageScheduleID, description: reason}
        //     doRejectScheduleByAdmin(submitReject).then(response => {
        //         Swal.fire({
        //             icon: 'error',
        //             title: response.data.message
        //         }).then(response => {
        //             this.doGetIncomingOrderSchedule()
        //         })
        //     }).catch(err => {
        //         console.log(err)
        //     })
        //     this.promptReject = false
        // },
        // handleResize () {
        //     this.window.width = window.innerWidth
        //     this.window.height = window.innerHeight
        //     this.window.heightAltered = window.innerHeight - (window.innerHeight * (15/100))
        // },
        changePage (url) {
            this.$router.push(url)
        }

    }
}
</script>