<template>
    <q-page class="px-30">
        <div class="pt-20 relative-position">
            <img class="responsive_img fw d-block m-auto" src="~assets/images/preset/bg_profile.png" alt="">
            <q-avatar class="bg-white absolute-img-profile" size="120px">
                <img v-if="!help.isDataEmpty(user.profilePicture)" :src="user.profilePicture">
                <i v-else class="fas fa-user grey-5"></i>
            </q-avatar>
        </div>
        <div class="pb-30">
            <div class="d-flex a-center j-sp-between mt-40 h-30px txt-white">
                <div class="d-flex a-center">
                    <div class="text-h5">Your Profile</div>
                    <q-btn v-if="!isEditable" @click="doRequestForgotPasswordEmail()" :loading="loader" unelevated color="primary" label="Change Password?" class="tf-capitalize ml-20"></q-btn>
                </div>
                <div v-if="isEditable">
                    <i class="fas fa-pen fs-20 edit-icon" @click="isEditable = !isEditable"></i>
                    <q-tooltip class="bg-primary text-body2 txt-white" self="center right" :offset="[10, 10]">
                        Edit Profile
                    </q-tooltip>
                </div>
                <div v-else>
                    <span class="txt-white text-h6 link_txt mr-10" @click="isEditable = !isEditable; doInsertUserDisplay()">Discard</span>
                    <span class="primary_color text-h6 link_txt">Save</span>
                </div>
            </div>
            <div class="q-gutter-y-lg pt-20 input-outline-profile">
                <div>
                    <span class="primary_color text-h6">Email</span>
                    <q-input v-model="userDisplay.email" outlined disable />
                </div>
                <div>
                    <span class="primary_color text-h6">Name</span>
                    <q-input v-model="userDisplay.name" outlined disable />
                </div>
                <div>
                    <span class="primary_color text-h6">Display Name</span>
                    <q-input v-model="userDisplay.dName" outlined :disable="isEditable" />
                </div>
                <div>
                    <span class="primary_color text-h6">Phone Number</span>
                    <q-input v-model="userDisplay.phoneNumber" outlined :disable="isEditable" />
                </div>
                <div>
                    <span class="primary_color text-h6">Date of Birth</span>
                    <q-input v-model="userDisplay.DoB" outlined :disable="isEditable" />
                </div>
            </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { requestForgotPasswordEmail } from '../../api/loginRegisterServices'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import Swal from 'sweetalert2'

export default {
    data () {
        return{
            help,
            loader: false,
            tes: 0,
            user: {},
            userDisplay: {
                dName: null,
                name: null,
                email: null,
                phoneNumber: null,
                DoB: null
            },
            isEditable: true
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doInsertUserDisplay()
    },
    methods: {
        doInsertUserDisplay () {
            this.userDisplay.dName = this.user.displayName
            this.userDisplay.name = this.user.fullName
            this.userDisplay.email = this.user.email
            this.userDisplay.phoneNumber = this.user.phoneNumber
            this.userDisplay.DoB = help.defaultFormat(this.user.DoB, help.data().dmy_7)
        },
        doRequestForgotPasswordEmail () {
            let _this = this
            _this.loader = true
            requestForgotPasswordEmail(_this.user).then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message
                }) .then((result) => {
                    if(result.isConfirmed){
                        _this.loader = false
                    }
                })
            }) .catch(function (error) {
                console.log(error.response)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.email
                })
                _this.loader = false
            })
        }
    }
}
</script>
