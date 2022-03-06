<template>
    <q-page class="pt-20">
        <div class="txt-white show-m w-90 m-auto" v-if="!help.isObjectEmpty(favoriteList) && !loader">
            <h5 class="m-0">Favorites</h5>
        </div>
        <div class="show-m w-90 m-auto" v-else-if="loader">
            <q-skeleton type="rect" width="50px" />
        </div>
        <div v-if="!help.isObjectEmpty(favoriteList) && !loader" class="row q-col-gutter-md w-90 m-auto">
            <div class="col-md-6 col-xs-12" v-for="item in favoriteList" :key="'fi' + item.id">
                <q-card class="my-card">
                    <q-card-section class="d-flex a-start j-sp-between">
                        <div class="d-flex a-center q-gutter-x-sm">
                            <div>
                                <div v-if="!help.isDataEmpty(item.workshopLogo)">
                                    <img class="responsive_img fit-content workshop-img-favorite" :src="item.workshopLogo" alt="">
                                </div>
                                <div class="no-logo-layout-3 fs-12" v-else>
                                    No Logo
                                </div>
                            </div>
                            <div class="d-flex j-sp-between flex-dir-col q-gutter-y-xs">
                                <span>{{item.workshopName}}</span>
                                <div class="d-flex a-center q-gutter-x-xs">
                                    <q-icon name="fas fa-map-marker-alt primary_color" />
                                    <span>{{ item.province }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-dir-col">
                            <q-badge v-if="item.status24Hr == '0'" class="tf-capitalize" :color="item.statusHr == 'tutup' ? 'grey-5' : 'primary'">
                                {{ item.statusHr == 'tutup' ? 'Closed' : 'Open' }}
                            </q-badge>
                            <q-badge color="orange-6" v-else>24 Hr</q-badge>
                        </div>
                    </q-card-section>
                    <q-separator color="#605A5A" size="1px" />
                    <q-card-section class="pt-8 q-col-gutter-y-lg">
                        <div>
                            <div class="text-subtitle2">
                                <span>Operational :&nbsp;</span>
                                <span :class="['', {'primary_color' : item.statusHr == 'buka'}, {'grey_3' : item.statusHr == 'tutup'}]">
                                    {{help.formatTime(item.operationalOpenHour, help.data().time_1)}} - {{help.formatTime(item.operationalCloseHour, help.data().time_1)}}
                                </span>
                            </div>
                            <q-rating
                                v-model="item.rating"
                                readonly
                                color="yellow-14"
                                icon="star_border"
                                icon-selected="star"
                            />
                        </div>
                        <div class="row a-center j-sp-between">
                            <div class="col-xs-12 flex j-sp-between show-m mb-10">
                                <q-btn
                                    @click="!item.favoriteToggle ? doAddFavoriteToUser(item) : doRemoveFavoriteFromUser(item)"
                                    :icon="item.favoriteToggle ? 'fas fa-heart' : 'far fa-heart'"
                                    flat round color="negative"
                                >
                                    <q-tooltip
                                        class="bg-primary text-body3"
                                    >
                                        {{ item.favoriteToggle ? 'Remove from favorite' : 'Add to favorite' }}
                                    </q-tooltip>
                                </q-btn>
                                <q-btn
                                    @click="doCheckForMakeChatRoom(item)"
                                    icon="fas fa-comment-dots"
                                    flat round color="primary"
                                />
                                <q-btn
                                    @click="openGoogleMapsWithCoords(item.latitude, item.longitude)"
                                    icon="fas fa-map-marker-alt"
                                    flat round color="primary"
                                />
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <q-btn
                                    @click="changePage('/workshop/detail/' + item.workshopID)"
                                    color="primary" rounded unelevated padding="4px 12px"
                                    label="See Full Profile"
                                    class="tf-capitalize hide-m"
                                />
                                <q-btn
                                    @click="changePage('/workshop/detail/' + item.workshopID)"
                                    color="primary" rounded unelevated padding="8px 12px"
                                    label="See Full Profile"
                                    class="tf-capitalize show-m fw"
                                />
                            </div>
                            <div class="col-md-6 flex j-end hide-m">
                                <q-btn
                                    @click="!item.favoriteToggle ? doAddFavoriteToUser(item) : doRemoveFavoriteFromUser(item)"
                                    :icon="item.favoriteToggle ? 'fas fa-heart' : 'far fa-heart'"
                                    flat round color="negative"
                                >
                                    <q-tooltip
                                        class="bg-primary text-body3"
                                    >
                                        {{ item.favoriteToggle ? 'Remove from favorite' : 'Add to favorite' }}
                                    </q-tooltip>
                                </q-btn>
                                <q-btn
                                    @click="doCheckForMakeChatRoom(item)"
                                    icon="fas fa-comment-dots"
                                    flat round color="primary"
                                />
                                <q-btn
                                    @click="openGoogleMapsWithCoords(item.latitude, item.longitude)"
                                    icon="fas fa-map-marker-alt"
                                    flat round color="primary"
                                />
                            </div>
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>
        <div v-else-if="loader" class="row q-col-gutter-md w-90 m-auto">
            <div class="col-md-6 col-xs-12">
                <q-card class="fw">
                    <q-item>
                        <q-item-section avatar>
                            <q-skeleton type="QToggle" />
                            </q-item-section>

                            <q-item-section>
                            <q-item-label class="d-flex j-sp-between">
                                <q-skeleton width="75%" type="text" />
                                <q-skeleton width="20%" type="text" />
                            </q-item-label>
                            <q-item-label caption>
                                <q-skeleton type="text" />
                            </q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-skeleton height="1px" type="text" />

                    <q-card-section class="pt-8">
                        <q-skeleton width="80%" type="text" />
                        <q-skeleton class="pt-8" width="80%" type="QRange" />
                    </q-card-section>

                    <q-card-section class="pt-8 d-flex j-sp-between hide-m-i">
                        <q-skeleton width="45%" type="QRange" />
                        <q-skeleton width="45%" type="QRange" />
                    </q-card-section>

                    <q-card-section class="pt-8 show-m-i">
                        <div class="d-flex j-sp-between pb-8">
                            <q-skeleton width="28%" type="QBtn" />
                            <q-skeleton width="28%" type="QBtn" />
                            <q-skeleton width="28%" type="QBtn" />
                        </div>
                        <q-skeleton type="QRange" />
                    </q-card-section>
                </q-card>
            </div>
        </div>
        <div v-else class="flex flex-dir-col flex-center q-page-height">
            <img class="responsive_img fit-content" width="400" src="~assets/images/preset/no_schedule_bg.png" alt="">
            <span class="fs-25 txt-white fw-semibold mt-10">No Favorite</span>
        </div>
    </q-page>
</template>

<style scoped>
    .q-col-gutter-y-md > *, .q-col-gutter-md > * {
        padding-left: 0;
        padding-right: 0;
    }
</style>

<script>
/* eslint-disable */
import { getFavoritesByUserID, removeFavoriteFromUser, addFavoriteToUser } from '../../api/FavoriteService'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'
import Swal from 'sweetalert2'
import main from '../../main'

export default {
    data(){
        return{
            help,
            ValidationFunction,
            loader: false,
            userToken: null,
            user: {},
            favoriteList: []
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.userToken = LocalStorage.getItem('autoRepairUser').data.access_token
        this.doGetFavoriteUser()
    },
    methods: {
        doGetFavoriteUser () {
            let _this = this
            _this.loader = true
            let token = LocalStorage.getItem('autoRepairUser').data.access_token
            getFavoritesByUserID(_this.user.id, token).then(response => {
                var tempObj = {
                    favoriteToggle: true
                }
                var tempArr = []
                tempArr = response.data.objectReturn
                tempArr.forEach(el1 => {
                    tempObj = {...tempObj, ...el1}
                    _this.favoriteList.push(tempObj)
                })
                _this.loader = false
            })  .catch((err) =>{ 
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
                var roomId = LocalStorage.getItem('autoRepairUser').data.user.tokenChat + '-' + userWorkshop.adminTokenChat
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
                    this.changePage('/member/home-message?userTokenChat=' + userTokenChat + '-' + userWorkshop.adminTokenChat + '&isFromOutside=' + true)
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please login first',
                    confirmButtonText: 'Login',
                    confirmButtonColor: '#21a17b',
                    showCancelButton: true,
                    cancelButtonText: 'Back',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'br-25px-i py-5-i px-20-i',
                        cancelButton: 'br-25px-i py-5-i px-20-i'
                    }
                }) .then((result) => {
                    if(result.isConfirmed){
                        this.changePage('/session/login')
                    }
                })
            }
        },
        doAddFavoriteToUser (item) {
            let _this = this
            addFavoriteToUser(item.customerID, item.workshopID, _this.userToken).then(response => {
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
            removeFavoriteFromUser(item.customerID, item.workshopID, _this.userToken).then(response => {
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