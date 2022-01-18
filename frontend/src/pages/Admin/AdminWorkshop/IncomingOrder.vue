<template>
    <q-page class="p-20" :style="{height: window.heightAltered + 'px'}">
        <div class="text-h6 fw-semibold mb-20">Incoming Order</div>
        <q-scroll-area
        :thumb-style="thumbStyle"
        :bar-style="barStyle"
        class="list-workshop-scrollbar h-80">
            <q-card class="w-80 m-auto">
                <q-card-section>
                    <q-card v-for="incoming in this.listIncoming" :key="incoming.scheduleID" class="adminWorkshop-card w-80 "  >
                        <q-card-section >
                            <q-card-section class="flex m-auto">
                                <div class="w-50">
                                    <div class="flex flex-dir-col mb-10">
                                        <span class="fw-semibold">Nama Pelanggan</span>
                                        <span>Joko Sutanto</span>
                                    </div>
                                    <div class="flex flex-dir-col mb-10">
                                        <span class="fw-semibold">Tanggal dan Waktu</span>
                                        <span>{{ help.defaultFormat(incoming.scheduleDate, help.data().dmy_8) }}</span>
                                        <span>{{ help.formatTime(incoming.scheduleTime, help.data().time_2) }}</span>
                                    </div>
                                    <div class="flex flex-dir-col mb-10">
                                        <span class="fw-semibold">Model dan Tipe Mobil</span>
                                        <span>Model : {{ incoming.carModel}} | Tipe: {{ incoming.carType}}</span>
                                        <!-- ni gw gatau urutannya model dl ap tipe dl -->
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
                                <div class="w-50 p">
                                    <span class="fw-semibold">Layanan yang dipilih : </span>
                                    <div class="flex flex-dir-col mb-10 ml-5">
                                        <span class="fw-semibold">Periodic Service :</span>
                                        <span>{{ Object.keys(incoming.serviceDetail.periodicService).length === 0 ?
                                            '-' : incoming.serviceDetail.periodicService.serviceDetail }}</span>
                                    </div>
                                    <div class="ml-5">
                                        <span class="fw-semibold">General Services: </span><br>
                                        <span v-for="service in incoming.serviceDetail.generalServices" :key="service.id">
                                            - {{ service.serviceDetail}}</span>
                                    </div>
                                </div>
                            </q-card-section>
                            <!-- <q-separator  class="br-5px" color="#605A5A" size="4px"/> -->
                            <div class="d-flex a-center j-end" style="gap: 20px">
                                <q-btn
                                    @click="promptReject = true"
                                    color="negative" rounded unelevated padding="4px 24px"
                                    label="Reject"
                                    class="tf-capitalize"
                                />
                                <q-btn
                                    @click="doSetTempScheduleID(incoming.scheduleID)"
                                    color="primary" rounded unelevated padding="4px 24px"
                                    label="Accept"
                                    class="tf-capitalize"
                                />
                            </div>
                        </q-card-section>
                    </q-card>
                </q-card-section>
            </q-card>
            </q-scroll-area>
        <q-dialog v-model="promptAccept">
            <q-card style="min-width: 480px" class="py-20" >
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Accept Schedule?</div>
                </q-card-section>

                <q-card-actions align="center" class="text-primary">
                    <q-btn label="Cancel" v-close-popup  @click="promptReject = false"/>
                    <q-btn color="primary" label="Accept" v-close-popup @click="doAcceptIncomingOrderSchedule()"/>
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
                    >
                    </q-input>
                </div>
                <q-card-actions align="right" class="text-primary">
                    <q-btn padding="4px 16px" color="primary" rounded label="Submit" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getIncomingOrderSchedule, doAcceptScheduleByAdmin } from '../../../api/AdminWorkshopServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'
import validationFunction from '../../../js/ValidationFunction'
export default {
    data () {
      return {
        help,
        validationFunction,
        user: [],
        listIncoming: [],
        tempManageScheduleID: null,
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
    mounted () {
        window.addEventListener('resize', this.handleResize)
        this.handleResize()
    },
    unmounted () {
        window.removeEventListener('resize', this.handleResize)
    },
    methods: {
        doGetIncomingOrderSchedule() {
            this.loader = true

            getIncomingOrderSchedule(this.user.id).then(response => {
                let tempListIncoming = []
                let tempListServiceDetails = []
                tempListIncoming = response.data.listSchedule
                tempListServiceDetails = response.data.listDetails
                tempListIncoming.forEach(el1 => {
                    let tempObject = {
                        serviceDetail: {
                            periodicService: {},
                            generalServices: []
                        }
                    }

                    tempListServiceDetails.forEach(el2 => {
                        if(el2.scheduleID === el1.scheduleID){
                            if(el2.serviceType === 'service umum'){
                                tempObject.serviceDetail.generalServices.push(el2)
                            }else{
                                tempObject.serviceDetail.periodicService = el2
                            }
                        }
                    })

                    tempObject = { ...tempObject, ...el1}
                    this.listIncoming.push(tempObject)
                })
                console.log('listIncoming',this.listIncoming)
            })

            this.loader = false
        },
        doSetTempScheduleID(scheduleID) {
            this.promptAccept = true
            this.tempManageScheduleID = scheduleID
            console.log(this.tempManageScheduleID)
        },
        doAcceptIncomingOrderSchedule() {
            this.loader = true
            doAcceptScheduleByAdmin(this.tempManageScheduleID)
            this.tempManageScheduleID = null
        },
        handleResize () {
            this.window.width = window.innerWidth
            this.window.height = window.innerHeight
            this.window.heightAltered = window.innerHeight - (window.innerHeight * (15/100))
            // this.window.heightAltered2 = window.innerHeight - (window.innerHeight * (/100))
        },
        changePage (url) {
            this.$router.push(url)
        }

    }
}
</script>