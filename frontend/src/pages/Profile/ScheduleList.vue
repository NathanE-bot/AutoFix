<template>
    <q-page>
        <q-card v-for="item in scheduleList" :key="item.id" class="my-card w-80 m-auto">
            <q-card-section>
                <div class="d-flex a-center j-sp-between mb-10">
                    <div class="text-h6">{{ item.workshopName }}</div>
                    <div class="">
                        <q-badge class="tf-capitalize mr-10 p-5" color="yellow" text-color="#ffffff" :label="item.scheduleStatus" />
                        <!-- <q-badge class="tf-capitalize p-5" text-color="#ffffff" label="New" /> -->
                    </div>
                </div>
                <q-separator class="br-5px" color="#605A5A" size="4px" />
                <div class="mt-10 row q-gutter-y-md">
                    <div class="col-md-12 flex-dir-col mt-0">
                        <span class="fw-semibold">Address</span>
                        <span>{{ item.workshopAddress }}</span>
                    </div>
                    <div class="col-md-5">
                        <span class="fw-semibold">Date and Time</span>
                        <div class="d-flex flex-dir-col">
                            <span>{{ help.defaultFormat(item.scheduleDate, help.data().dmy_7) }}</span>
                            <span>{{ help.formatTime(item.scheduleTime, help.data().time_2) + ' WIB' }}</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <span class="fw-semibold">Services</span>
                        <div class="d-flex a-start" v-if="!help.isObjectEmpty(item.serviceDetail.generalServices)">
                            <span style="min-width:120px; max-width:120px; width:120px">General Services:&nbsp;</span>
                            <div class="d-flex flex-dir-col">
                                <span v-for="gn in item.serviceDetail.generalServices" :key="'gn'+gn.id">{{ gn.serviceDetail }}</span>
                            </div>
                        </div>
                        <div class="d-flex a-start" v-if="!help.isObjectEmpty(item.serviceDetail.periodicSerivce)">
                            <span style="min-width:120px; max-width:120px; width:120px">Periodic Services:&nbsp;</span>
                            <div class="d-flex flex-dir-col">
                                <span>{{ item.serviceDetail.periodicSerivce.serviceDetail }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 flex-dir-col">
                        <span class="fw-semibold">Car Model and Type</span>
                        <span>{{ item.carModel + ' ' + item.carType}}</span>
                    </div>
                    <div class="col-md-5 flex-dir-col">
                        <span class="fw-semibold">Estimation Service Time</span>
                        <span>{{ item.timeEstimation + ' Hour' }}</span>
                    </div>
                    <div class="col-md-5 flex-dir-col">
                        <span class="fw-semibold">Description</span>
                        <span>{{ item.description }}</span>
                    </div>
                    <div class="col-md-12 row mt-30 a-center">
                        <div class="col-md-6 primary_color">
                            <span class="fw-bold text-h6">Price Estimation: {{ ValidationFunction.convertToRupiah(item.priceEstimation) }}</span>
                        </div>
                        <div class="col-md-5 q-gutter-x-lg j-end">
                            <q-btn
                                @click="test = !test"
                                :icon="test ? 'fas fa-heart' : 'far fa-heart'"
                                flat round color="primary"
                            />
                            <q-btn
                                @click="changePage('/member/home-message/room-message/' + this.user.tokenChat + '-' + item.tokenChat)"
                                icon="fas fa-comment-dots"
                                flat round color="primary"
                            />
                            <q-btn
                                @click="openGoogleMapsWithCoords(item.lat, item.lon)"
                                icon="fas fa-map-marker-alt"
                                flat round color="primary"
                            />
                        </div>
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getScheduleList } from '../../api/ScheduleService'
import { getWorkshopById, getUserWorkshopByWorkshopId } from '../../api/workshopService'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'

export default {
    data(){
        return {
            help,
            ValidationFunction,
            user: [],
            scheduleList: [],
            test: false,
            workshopById: {
                defaultData: [],
                servisBerkala: [],
                servisUmum: []
            },
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doGetScheduleList()
    },
    methods: {
        doGetScheduleList () {
            let _this = this
            _this.loader = true
            let token = LocalStorage.getItem('autoRepairUser').data.access_token
            getScheduleList(_this.user.id, token).then(response => {
                let tempScheduleList = []
                let tempScheduleDetails = []
                tempScheduleList = response.data.schedules
                tempScheduleDetails = response.data.serviceDetail
                tempScheduleList.forEach(el1 => {
                    let tempObject = {
                        serviceDetail: {
                            periodicSerivce: {},
                            generalServices: []
                        },
                        lon: null,
                        lat: null,
                        tokenChat: null
                    }
                    tempScheduleDetails.forEach(el2 => {
                        if(el2.scheduleID === el1.id){
                            if(el2.serviceType == 'service umum'){
                                tempObject.serviceDetail.generalServices.push(el2)
                            } else {
                                tempObject.serviceDetail.periodicSerivce = el2
                            }
                        }
                    })
                    tempObject = {...tempObject, ...el1}
                    _this.doGetWorkshopById(tempObject.workshopID, tempObject)
                    _this.doGetUserWorkshopByWorkshopId(tempObject.workshopID, tempObject)
                    _this.scheduleList.push(tempObject)
               })
               console.log(_this.scheduleList)
            })
            _this.loader = false
        },
        doGetWorkshopById (id, obj) {
            let _this = this
            getWorkshopById(id).then(response => {
                obj.lon = response.data.longitude
                obj.lat = response.data.latitude
                _this.doGetUserWorkshopByWorkshopId(id, obj)
            }) .catch((err) =>{ 
                console.log(err)
            })
        },
        doGetUserWorkshopByWorkshopId (id, obj) {
            let _this = this
            getUserWorkshopByWorkshopId(id).then(response => {
                obj.tokenChat = response.data.tokenChat
                _this.loader = false
            }).catch((err) =>{
                console.log(err)
                _this.loader = false
            })
        },
        openGoogleMapsWithCoords (lat, lon) {
            if(!help.isDataEmpty(lat) && !help.isDataEmpty(lon)){
                var url = "https://maps.google.com/?q=" + lat + "," + lon
                window.open(url, '_blank')
            }
        },
        changePage (url) {
            this.$router.push(url)
        }
    }
}
</script>