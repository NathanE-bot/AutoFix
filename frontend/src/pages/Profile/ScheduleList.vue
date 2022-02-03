<template>
    <q-page>
        <div v-if="!help.isObjectEmpty(scheduleList) && !loader" class="d-flex flex-dir-col a-center py-20 q-gutter-y-lg q-page-height">
            <q-card v-for="item in scheduleList" :key="'sl' + item.id" class="my-card w-70">
                <q-card-section>
                    <div class="d-flex a-center j-sp-between mb-10">
                        <div class="text-h5 fw-semibold">{{ item.workshopName }}</div>
                        <div>
                            <q-badge class="tf-capitalize mr-10 p-5" :color="item.scheduleStatus == 'waiting confirmation' ? 'orange-5' : 'accent'" text-color="#ffffff" :label="item.scheduleStatus" />
                            <!-- <q-badge class="tf-capitalize p-5" text-color="#ffffff" label="New" /> -->
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
                            <div class="col-md-6 primary_color">
                                <span class="fw-bold text-h6">Price Estimation: {{ ValidationFunction.convertToRupiah(item.priceEstimation) }}</span>
                            </div>
                            <div class="col-md-5 q-gutter-x-lg j-end">
                                <q-btn
                                    @click="!item.favoriteToggle ? doAddFavoriteToUser(item) : doRemoveFavoriteFromUser(item)"
                                    :icon="item.favoriteToggle ? 'fas fa-heart' : 'far fa-heart'"
                                    flat round color="negative"
                                />
                                <q-btn
                                    @click="doCheckForMakeChatRoom(item)"
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
                                <q-skeleton v-for="n in 3" :key="'bl-' + n" type="QToggle" width="60px" />
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
            <img class="responsive_img fit-content" width="450" src="~assets/images/preset/no_schedule_bg.png" alt="">
            <span class="fs-30 txt-white fw-semibold mt-10">No Schedule Yet</span>
            <q-btn
                @click="changePage('/workshop')"
                class="tf-capitalize mt-30 fw-semibold br-10px fs-20"
                rounded color="primary"
                label="Make Schedule"
                padding="16px 24px"
            />
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getScheduleList } from '../../api/ScheduleService'
import { addFavoriteToUser, removeFavoriteFromUser, getFavoritesByUserID } from '../../api/FavoriteService'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'
import Swal from 'sweetalert2'
import main from '../../main'

export default {
    data(){
        return {
            help,
            ValidationFunction,
            loader: false,
            user: {},
            userToken: null,
            scheduleList: [],
            favoriteList: [],
            workshopById: {
                defaultData: [],
                servisBerkala: [],
                servisUmum: []
            }
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.userToken = LocalStorage.getItem('autoRepairUser').data.access_token
        this.doGetFavoritesByUserID()
    },
    methods: {
        doGetFavoritesByUserID () {
            let _this = this
            _this.loader = true
            _this.favoriteList = []
            getFavoritesByUserID(_this.user.id, _this.userToken).then(response => {
                _this.favoriteList = response.data.objectReturn
                _this.doGetScheduleList()
            }) .catch((err) =>{
                console.log(err)
                _this.loader = false
            })
        },
        doGetScheduleList () {
            let _this = this
            let token = LocalStorage.getItem('autoRepairUser').data.access_token
            getScheduleList(_this.user.id, token).then(response => {
                let tempScheduleList = []
                let tempScheduleDetails = []
                tempScheduleList = response.data.schedules
                tempScheduleDetails = response.data.serviceDetail
                if(help.isObjectEmpty(tempScheduleList) && help.isObjectEmpty(tempScheduleDetails)) {
                    _this.loader = false
                } else {
                    tempScheduleList.forEach(el1 => {
                        var tempObject = {
                            serviceDetail: {
                                periodicSerivce: {},
                                generalServices: []
                            },
                            favoriteToggle: false
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
                        _this.scheduleList.push(tempObject)
                        if(!help.isObjectEmpty(_this.favoriteList)){
                            _this.favoriteList.forEach(el3 => {
                                if(el3.customerID == tempObject.userID && el3.workshopID == tempObject.workshopID){
                                    tempObject.favoriteToggle = true
                                }
                            })
                        }
                    })
                }
            }) .finally(() => {
                _this.scheduleList.reverse()
                _this.loader = false
            }) .catch((err) =>{ 
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
        doCheckForMakeChatRoom (userWorkshop) {
            let user_1 = ''
            let user_2 = ''
            var userTokenChat = LocalStorage.getItem('autoRepairUser').data.user.tokenChat
            console.log(userWorkshop)
            if(LocalStorage.has('autoRepairUser')){
                user_1 = LocalStorage.getItem('autoRepairUser').data.user.fullName
                user_2 = userWorkshop.workshopName
                var roomId = LocalStorage.getItem('autoRepairUser').data.user.tokenChat + '-' + userWorkshop.adminToken
            }
            if(!help.isDataEmpty(roomId)){
                main
                    .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
                    .ref("chatRoom/" + roomId + "/user-1")
                    .set(user_1)
                main
                    .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
                    .ref("chatRoom/" + roomId + "/user-2")
                    .set(user_2)
                if(help.isDataEmpty(userTokenChat)){
                    Swal.fire({
                        title: 'Error',
                        text: 'Please contact website admin.'
                    })
                } else {
                    this.changePage('/member/home-message?userTokenChat=' + userTokenChat + '-' + userWorkshop.adminToken)
                }
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Please login first.',
                    confirmButtonText: 'Login',
                    confirmButtonColor: '#21a17b',
                    showCancelButton: true,
                    cancelButtonText: 'Back',
                }) .then((result) => {
                    if(result.isConfirmed){
                        this.changePage('/session/login')
                    }
                })
            }
        },
        doAddFavoriteToUser (item) {
            let _this = this
            addFavoriteToUser(item.userID, item.workshopID, _this.userToken).then(response => {
                console.log(response.data.message)
                item.favoriteToggle = !item.favoriteToggle
                this.$q.notify({
                    type: 'positive',
                    message: 'Added to favorite!',
                    color: 'primary',
                    timeout: 1000
                })
            }) .catch((err) =>{
                console.log(err)
                _this.loader = false
            })
        },
        doRemoveFavoriteFromUser (item) {
            let _this = this
            removeFavoriteFromUser(item.userID, item.workshopID, _this.userToken).then(response => {
                console.log(response.data.message)
                item.favoriteToggle = !item.favoriteToggle
                this.$q.notify({
                    type: 'positive',
                    message: 'Removed to favorite!',
                    color: 'negative',
                    timeout: 1000
                })
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