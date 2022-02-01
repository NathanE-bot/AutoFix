<template>
    <q-page>
        <div v-if="!help.isObjectEmpty(historyList) && !loader" class="d-flex flex-dir-col a-center py-20 q-gutter-y-lg q-page-height">
            <q-card v-for="item in historyList" :key="'sl' + item.id" class="my-card w-70">
                <q-card-section>
                    <div class="d-flex a-center j-sp-between mb-10">
                        <div class="text-h5 fw-semibold">{{ item.workshopName }}</div>
                        <div class="">
                            <q-badge
                                class="tf-capitalize mr-10 p-5"
                                :color="item.scheduleStatus == 'done' ? 'primary' : item.scheduleStatus == 'cancelled' || item.scheduleStatus == 'rejected' ? 'negative' : ''"
                                text-color="#ffffff"
                                :label="item.scheduleStatus"
                            />
                        </div>
                    </div>
                    <q-separator class="br-5px" color="#605A5A" size="4px" />
                    <div class="mt-10 q-gutter-y-md row">
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
                                <span class="w3-120px">General Services:&nbsp;</span>
                                <div class="d-flex flex-dir-col">
                                    <span v-for="gn in item.serviceDetail.generalServices" :key="'gn'+gn.id">{{ gn.serviceDetail }}</span>
                                </div>
                            </div>
                            <div class="d-flex a-start" v-if="!help.isObjectEmpty(item.serviceDetail.periodicSerivce)">
                                <span class="w3-120px">Periodic Services:&nbsp;</span>
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
                            <span>{{ item.serviceDescription }}</span>
                        </div>
                        <div class="col-md-12 row mt-30 a-center">
                            <div class="col-md-6 text-h6 primary_color">
                                <b>Price Estimation: {{ ValidationFunction.convertToRupiah(item.priceEstimation) }}</b>
                            </div>
                            <div class="col-md-6 q-gutter-x-lg j-end">
                                <q-btn v-if="item.scheduleStatus == 'done' && item.isReviewed == 0" class="tf-capitalize" rounded unelevated color="warning" label="Review" @click="doOpenReviewDialog(item)" />
                                <q-btn v-if="item.isReviewed == 1" class="tf-capitalize" rounded unelevated color="primary" label="Make Schedule" @click="changePage('/member/workshop/make-schedule/' + item.workshopID)" />
                            </div>
                        </div>
                    </div>
                </q-card-section>
            </q-card>
        </div>
        <div v-else-if="loader" class="d-flex flex-dir-col a-center py-20 q-gutter-y-lg q-page-height">
            <q-card class="my-card w-70">
                <q-card-section>
                    <div class="d-flex a-center j-sp-between mb-10">
                        <q-skeleton type="rect" width="80px" />
                        <div class="d-flex a-center q-gutter-x-md">
                            <q-skeleton type="text" width="70px" />
                            <q-skeleton type="text" width="30px" />
                        </div>
                    </div>
                    <q-skeleton type="text" />
                    <div class="mt-10 row q-gutter-y-md">
                        <div class="col-md-12 flex-dir-col mt-0">
                            <q-skeleton type="text" width="50px" />
                            <q-skeleton type="text" width="100px" />
                        </div>
                        <div class="col-md-5">
                            <q-skeleton type="text" width="60px" />
                            <div class="d-flex flex-dir-col">
                                <q-skeleton type="text" width="130px" />
                                <q-skeleton type="text" width="60px" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <q-skeleton type="text" width="40px" />
                            <div class="d-flex a-start">
                                <q-skeleton type="text" class="w3-120px mr-10" />
                                <div class="d-flex flex-dir-col">
                                    <q-skeleton v-for="n in 2" :key="'loader-gn' + n" type="text" width="50px" />
                                </div>
                            </div>
                            <div class="d-flex a-start">
                                <q-skeleton type="text" class="w3-120px" />
                                <div class="d-flex flex-dir-col">
                                    <q-skeleton type="text" width="60px" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 flex-dir-col">
                            <q-skeleton type="text" width="60px" />
                            <q-skeleton type="text" width="100px" />
                        </div>
                        <div class="col-md-5 flex-dir-col">
                            <q-skeleton type="text" width="80px" />
                            <q-skeleton type="text" width="110px" />
                        </div>
                        <div class="col-md-5 flex-dir-col">
                            <q-skeleton type="text" width="40px" />
                            <q-skeleton type="text" width="140px" />
                        </div>
                        <div class="col-md-12 row mt-30 a-center">
                            <div class="col-md-6 primary_color">
                                <q-skeleton type="rect" width="200px" />
                            </div>
                            <div class="col-md-5 q-gutter-x-lg j-end">
                                <q-skeleton type="QToggle" width="150px" />
                            </div>
                        </div>
                    </div>
                </q-card-section>
            </q-card>
            <div class="w-70 q-gutter-y-sm">
                <q-skeleton class="black-bg-loader" type="QToggle" width="50%" />
                <q-skeleton class="black-bg-loader" type="rect" width="30%" />
                <q-skeleton class="black-bg-loader" type="text" width="20%" />
            </div>
        </div>
        <div v-else class="flex flex-dir-col flex-center q-page-height">
            <img class="responsive_img fit-content" width="400" src="~assets/images/preset/no_schedule_bg.png" alt="">
            <span class="fs-25 txt-white fw-semibold mt-10">No History</span>
        </div>
        <q-dialog v-model="reviewScheduleDialog">
            <q-card class="my-card card-size-m">
                <q-card-section class="q-gutter-y-md">
                    <div class="d-flex a-center q-gutter-x-lg">
                        <img class="responsive_img fit-content" width="90" src="~assets/images/logo/workshop/honda.png" alt="">
                        <span class="text-h5 fw-semibold">{{ tempHistorySchedule.workshopName }}</span>
                    </div>
                    <div class="d-flex a-baseline j-sp-between">
                        <span>Tell us what you think about this place</span>
                        <q-rating
                          v-model="review.rating"
                          no-reset
                          color="yellow-14"
                          icon="star_border"
                          icon-selected="star"
                        />
                    </div>
                    <q-input
                        v-model="review.description"
                        outlined counter maxlength="500"
                        type="textarea"
                        class="fix-txt-field default-textarea-1"
                    />
                </q-card-section>
                <q-card-section>
                    <div class="d-flex a-center j-end q-gutter-x-sm">
                        <q-btn class="tf-capitalize" flat rounded color="primary" label="Cancel" @click="doCloseReviewDialog()" />
                        <q-btn class="tf-capitalize" unelevated rounded color="primary" label="Submit" @click="doReviewSchedule()"  />
                    </div>
                </q-card-section>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getHistoryScheduleList, reviewSchedule } from '../../api/ScheduleService'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'
import Swal from 'sweetalert2'

export default {
    data(){
        return {
            help,
            ValidationFunction,
            loader: false,
            reviewScheduleDialog: false,
            user: {},
            historyList: [],
            tempHistorySchedule: {},
            workshopById: {
                defaultData: [],
                servisBerkala: [],
                servisUmum: []
            },
            review: {
                scheduleID: null,
                workshopID: null,
                userName: null,
                reviewDate: null,
                rating: null,
                description: ''
            }
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doGetScheduleList()
    },
    methods: {
        doOpenReviewDialog (selectedSchedule) {
            this.tempHistorySchedule = selectedSchedule
            this.reviewScheduleDialog = true
        },
        doCloseReviewDialog () {
            this.tempHistorySchedule = {}
            this.review.scheduleID = null
            this.review.workshopID = null
            this.review.userName = null
            this.review.reviewDate = null
            this.review.rating = null
            this.review.description = ''
            this.reviewScheduleDialog = false
        },
        doReviewSchedule () {
            let _this = this
            _this.reviewLoader = true
            _this.review.scheduleID = _this.tempHistorySchedule.id
            _this.review.workshopID = _this.tempHistorySchedule.workshopID
            _this.review.userName = _this.user.fullName
            _this.review.reviewDate = help.formatToday(help.data().dmy_9)
            let token = LocalStorage.getItem('autoRepairUser').data.access_token
            reviewSchedule(_this.review, token).then(response => {
                _this.historyList.forEach(el1 => {
                    if(_this.tempHistorySchedule.id == el1.id){
                        el1.isReviewed = 1
                    }
                })
                _this.doCloseReviewDialog()
                _this.reviewLoader = false
                Swal.fire({
                    icon: 'success',
                    title: response.data.messageTitle,
                    text: response.data.messageSubtitle
                })
            }) .catch(function (error) {
                _this.doCloseReviewDialog()
                if(error.response.data.errId == 1){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.response.data.message
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please contact our admin'
                    })
                }
                _this.reviewLoader = false
            })
        },
        doGetScheduleList () {
            let _this = this
            _this.loader = true
            let token = LocalStorage.getItem('autoRepairUser').data.access_token
            getHistoryScheduleList(_this.user.id, token).then(response => {
                let tempScheduleList = []
                let tempScheduleDetails = []
                tempScheduleList = response.data.schedules
                tempScheduleDetails = response.data.serviceDetail
                if(help.isObjectEmpty(tempScheduleList) && help.isObjectEmpty(tempScheduleDetails)) {
                    _this.loader = false
                } else {
                    var counter = 0
                    tempScheduleList.forEach(el1 => {
                        counter++
                        let tempObject = {
                            serviceDetail: {
                                periodicSerivce: {},
                                generalServices: []
                            }
                        }
                        tempScheduleDetails.forEach(el2 => {
                            if(el2.scheduleID === el1.id){
                                if(el2.serviceType == 'servis umum'){
                                    tempObject.serviceDetail.generalServices.push(el2)
                                } else {
                                    tempObject.serviceDetail.periodicSerivce = el2
                                }
                            }
                        })
                        tempObject = {...tempObject, ...el1}
                        _this.historyList.push(tempObject)
                    })
                }
            }) .finally(() => {
                _this.historyList.reverse()
                _this.loader = false
            }) .catch((err) =>{ 
                console.log(err)
                _this.loader = false
            })
        },
        changePage (url) {
            this.$router.push(url)
        }
    }
}
</script>