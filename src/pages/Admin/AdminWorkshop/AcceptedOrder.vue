<template>
    <q-page>
        <div class="w-80 m-auto">
            <div class="text-h5 fw-semibold py-20 txt-white" style="border-bottom: 1px solid #3b3b3b">Accepted Order</div>
        </div>
        <div class="w-80 m-auto py-20" v-if="!help.isObjectEmpty(listAccepted)">
            <q-scroll-area
            :thumb-style="thumbStyle"
            :bar-style="barStyle"
            class="list-workshop-scrollbar h-80"
            :style="{height: window.heightAltered + 'px'}">
                <q-card v-for="accepted in listAccepted" :key="accepted.scheduleID" class="adminWorkshop-card w-80 br-10px-i">
                    <q-card-section>
                        <div class="flex flex-center j-sp-between mb-10">
                            <div class="fw-semibold p-10">
                                <span>{{ accepted.fullName }}</span>
                            </div>
                            <div>
                                <q-badge class="tf-capitalize mr-10 p-5" color="accent" text-color="#ffffff" :label="accepted.scheduleStatus" />
                            </div>
                        </div>
                        <q-separator/>
                        <q-card-section class="flex m-auto">
                            <div class="w-40">
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Tanggal dan Waktu</span>
                                    <span>{{ help.defaultFormat(accepted.scheduleDate, help.data().dmy_8) }}</span>
                                    <span>{{ help.formatTime(accepted.scheduleTime, help.data().time_2) }}</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Model dan Tipe Mobil</span>
                                    <span>{{ accepted.carModel}} {{ accepted.carType}}</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Estimasi waktu pengerjaan</span>
                                    <span> {{ accepted.timeEstimation}} Jam</span>
                                </div>
                                <div class="flex flex-dir-col mb-10">
                                    <span class="fw-semibold">Estimasi Harga</span>
                                    <span>{{ validationFunction.convertToRupiah(accepted.priceEstimation) }}</span>
                                </div>
                            </div>
                            <div class="w-60">
                                <span class="fw-semibold">Layanan yang dipilih : </span>
                                <div v-if="Object.keys(accepted.serviceDetail.periodicService).length !== 0" class="flex flex-dir-col mb-10 ml-5">
                                    <span class="fw-semibold">Periodic Service :</span>
                                    <span>{{ accepted.serviceDetail.periodicService.serviceDetail }}</span>
                                </div>
                                <div v-if="accepted.serviceDetail.generalServices.length !== 0" class="ml-5">
                                    <span class="fw-semibold">General Services: </span><br>
                                    <div>
                                        <span class="flex flex-dir-col" v-for="service in accepted.serviceDetail.generalServices" :key="service.id">
                                            - {{ service.serviceDetail}}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="accepted.serviceDescription !== null">
                                <span class="fw-semibold">Service Request: </span>
                                <p class="m-0">{{ accepted.serviceDescription }}</p>
                            </div>
                        </q-card-section>
                        <div class="d-flex a-center j-end" style="gap: 20px">
                            <q-btn
                                @click="doSetTempScheduleID(accepted.scheduleID, 'cancel'); cancelReason = null;"
                                color="negative" rounded unelevated padding="4px 24px"
                                label="Cancel"
                                class="tf-capitalize"
                            />
                            <q-btn
                                @click="doHandleIncomingOrder('done', '', accepted.scheduleID)"
                                color="primary" rounded unelevated padding="4px 24px"
                                label="Finish"
                                class="tf-capitalize"
                            />
                        </div>
                    </q-card-section>
                </q-card>
            </q-scroll-area>
        </div>
        <div v-else class="w-80 m-auto py-20 text-align-center txt-white">
            No Data
        </div>
        <q-dialog v-model="promptDone">
            <q-card style="min-width: 480px" class="py-20 br-10px-i">
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Finish Schedule?</div>
                </q-card-section>

                <q-card-actions align="center" class="text-primary">
                    <q-btn label="Cancel" v-close-popup @click="promptReject = false"/>
                    <q-btn color="primary" label="Done" v-close-popup @click="doHandleIncomingOrder('done', '')"/>
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="promptCancel">
            <q-card style="min-width: 640px" class="p-16 br-10px-i">
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Please insert your reason for Cancelling</div>
                </q-card-section>
                <div class="m-auto">
                    <q-input
                        outlined
                        type="textarea"
                        class="fix-txt-field default-textarea-1 w-80 m-auto"
                        v-model="cancelReason"
                    >
                    </q-input>
                </div>
                <q-card-actions align="right" class="text-primary">
                    <q-btn padding="4px 16px" color="primary" rounded flat no-caps label="Cancel" v-close-popup />
                    <q-btn padding="4px 16px" color="primary" rounded unelevated no-caps label="Submit" v-close-popup @click="doHandleIncomingOrder('cancel',this.cancelReason, null)"/>
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getScheduleAcceptedByAdmin, doDoneScheduleByAdmin, doCancelScheduleByAdmin } from '../../../api/AdminWorkshopServices'
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
        listAccepted: [],
        tempManageScheduleID: null,
        cancelReason: null,
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
        promptDone: false,
        promptCancel: false 
      }
    },
    created() {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doGetAcceptedOrder()
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
        doGetAcceptedOrder(){
            this.loader = true
            this.listAccepted = []

            getScheduleAcceptedByAdmin(this.user.id).then(response => {
                console.log(response)

                let tempListSchedule = []
                let tempListDetails = []
                let tempListCustomer = []
                tempListSchedule = response.data.listSchedule
                tempListDetails = response.data.listDetails
                tempListCustomer = response.data.listDataCustomer

                tempListSchedule.forEach(el1 => {
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

                    tempListDetails.forEach(el2 => {
                        if(el2.scheduleID === el1.scheduleID){
                            if(el2.serviceType === 'servis umum'){
                                tempObject.serviceDetail.generalServices.push(el2)
                            }else{
                                tempObject.serviceDetail.periodicService = el2
                            }
                        }
                    })

                    tempListCustomer.forEach(el2 => {
                        if(el1.customerID === el2.customerID){
                            tempObjectCustomer = el2
                        }
                    })

                    tempObject = { ...tempObject, ...el1, ...tempObjectCustomer}
                    this.listAccepted.push(tempObject)
                })
                console.log(this.listAccepted)
            })

            this.loader = false
        },
        doSetTempScheduleID(scheduleID, action) {
            if(action === 'done'){
                this.promptDone = true
            }else{
                this.promptCancel = true
            }
            this.tempManageScheduleID = scheduleID
        },
        doHandleIncomingOrder(action, reason, id) {
            this.loader = true
            if(action === 'done'){
                this.tempManageScheduleID = id
                Swal.fire({
                    icon: 'question',
                    title: 'Finish schedule?',
                    confirmButtonText: 'Finish',
                    confirmButtonColor: '#21a17b',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'br-25px-i py-5-i px-20-i',
                        cancelButton: 'br-25px-i py-5-i px-20-i'
                    }
                }) .then((result) => {
                    if(result.isConfirmed) {
                            doDoneScheduleByAdmin(this.tempManageScheduleID).then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: response.data.message,
                            }).then(response => {
                                this.doGetAcceptedOrder()
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
                    }
                })
            }else if(action === 'cancel'){
                let submitReject = {}
                submitReject = { scheduleID: this.tempManageScheduleID, description: reason}
                doCancelScheduleByAdmin(submitReject).then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message
                    }).then(response => {
                        this.doGetAcceptedOrder()
                    })
                }).catch(err => {
                    // console.log(err)
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
        }
    },
}
</script>