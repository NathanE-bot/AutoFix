<template>
    <q-page>
        <div class="w-80 m-auto">
            <div class="text-h5 fw-semibold py-20 txt-white">Accepted Order</div>
            </div>
            <div class="white-1bg w-80 m-auto py-20">
                <q-card v-for="accepted in this.listAccepted" :key="accepted.scheduleID" class="adminWorkshop-card w-80">
                    <!-- <q-scroll-area
                    :thumb-style="thumbStyle"
                    :bar-style="barStyle"
                    class="list-workshop-scrollbar h-80"> -->
                        <q-card-section >
                            <div class="flex j-sp-between mb-10">
                                <div class="flex flex-center flex-dir-col">
                                    <span class="fw-semibold p-10">{{ accepted.fullName}}</span>
                                </div>
                                <div class="flex primary-bg px-15 br-10 br-20px align-item-center txt-white tf-capitalize">
                                    {{ accepted.scheduleStatus }}
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
                                    @click="doSetTempScheduleID(accepted.scheduleID, 'cancel')"
                                    color="negative" rounded unelevated padding="4px 24px"
                                    label="Cancel"
                                    class="tf-capitalize"
                                />
                                <q-btn
                                    @click="doSetTempScheduleID(accepted.scheduleID, 'done')"
                                    color="primary" rounded unelevated padding="4px 24px"
                                    label="Done"
                                    class="tf-capitalize"
                                />
                            </div>
                        </q-card-section>
                    <!-- </q-scroll-area> -->
                </q-card>
            </div>
        <q-dialog v-model="promptDone">
            <q-card style="min-width: 480px" class="py-20" >
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Finish Schedule?</div>
                </q-card-section>

                <q-card-actions align="center" class="text-primary">
                    <q-btn label="Cancel" v-close-popup  @click="promptReject = false"/>
                    <q-btn color="primary" label="Done" v-close-popup @click="doHandleIncomingOrder('done', '')"/>
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="promptCancel">
            <q-card style="min-width: 640px" class="p-16">
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
                    <q-btn padding="4px 16px" color="primary" rounded label="Submit" v-close-popup @click="doHandleIncomingOrder('cancel',this.cancelReason)"/>
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
        user: [],
        listAccepted: [],
        tempManageScheduleID: null,
        cancelReason: '',
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
    methods: {
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
                            if(el2.serviceType === 'service umum'){
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
        doHandleIncomingOrder(action, reason) {
            this.loader = true
            if(action === 'done'){
                doDoneScheduleByAdmin(this.tempManageScheduleID).then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                    }).then(response => {
                        this.doGetAcceptedOrder()
                    })
                }).catch(err => {
                    console.log(err)
                })
                this.promptAccept = false
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
                    console.log(err)
                })
                this.promptReject = false
            }
        }
    },
}
</script>