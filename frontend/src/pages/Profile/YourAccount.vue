<template>
    <q-page class="px-30">
        <div class="pt-20 relative-position">
            <img class="responsive_img fw d-block m-auto" src="~assets/images/preset/bg_profile.png" alt="">
            <q-avatar class="bg-white absolute-img-profile relative-position" size="120px">
                <q-badge v-if="!help.isDataEmpty(userDisplay.profilePicture) && !isEditable" class="discardDP cursor-pointer" rounded color="red" @click="user.profilePicture = ''">X</q-badge>
                <img :class="['responsive_img', {'z-opacity w-0-i' : help.isDataEmpty(userDisplay.profilePicture)}]" src="#" id="myImg">
                <i v-if="help.isDataEmpty(userDisplay.profilePicture)" class="fas fa-user grey-5"></i>
                <q-btn icon="fas fa-pen" fab-mini class="edit-img-btn cursor-pointer" text-color="white" color="secondary" v-if="!isEditable">
                    <div class="input-hide">
                        <input class="cursor-pointer" type="file" accept=".png,.jpg,.jpeg" id="uploadDPUser" @change="doUploadProfilePicture($event)">
                    </div>
                </q-btn>
            </q-avatar>
        </div>
        <div class="pb-30">
            <div class="d-flex a-center j-sp-between mt-40 h-30px txt-white">
                <div class="d-flex a-center">
                    <div class="text-h5">Your Profile</div>
                    <q-btn v-if="!isEditable" @click="doRequestForgotPasswordEmail()" :loading="loader" unelevated rounded color="primary" label="Change Password?" class="tf-capitalize ml-20"></q-btn>
                </div>
                <div v-if="isEditable">
                    <i class="fas fa-pen fs-20 edit-icon" @click="isEditable = !isEditable"></i>
                    <q-tooltip class="bg-primary text-body2 txt-white" self="center right" :offset="[10, 10]">
                        Edit Profile
                    </q-tooltip>
                </div>
                <div v-else>
                    <span class="text-negative text-h6 link_txt mr-10" @click="isEditable = !isEditable; doInsertUserDisplay(false)">Discard</span>
                    <span class="primary_color text-h6 link_txt" @click="doUpdateDataUserProfile()">Save</span>
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
            <div class="d-flex a-center j-end mt-20">
                <q-btn color="negative" unelevated rounded class="tf-capitalize" @click="doDeleteAccount()">Delete Account</q-btn>
            </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { requestForgotPasswordEmail } from '../../api/loginRegisterServices'
import { updateDataUserProfile } from '../../api/UserService'
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
                DoB: null,
                profilePicture: null
            },
            isEditable: true
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doInsertUserDisplay(true)
    },
    methods: {
        doUploadProfilePicture (event) {
            console.log(event)
            var inputFile = event.target.files || event.dataTransfer.files
            if(!inputFile.length) return null

            var inputFileType = inputFile[0].type
            if(!help.isValidImageType(inputFileType)){
                Swal.fire ({
                    icon: "error",
                    title: "Input Error",
                    text: "File type is not .png, .jpg, or .jpeg"
                })
                document.getElementById('uploadDPUser').value = ''
            }
            // this.user.profilePicture = inputFile[0].name
            var reader = new FileReader()
            var preview = document.getElementById('myImg'); // Image reference
            var file = inputFile[0];  // File refrence
            this.user.profilePicture = document.getElementById('uploadDPUser').value
            this.userDisplay.profilePicture = this.user.profilePicture 
            var reader = new FileReader(); // Creating reader instance from FileReader() API

            reader.addEventListener("load", function () { // Setting up base64 URL on image
                preview.src = reader.result;
            }, false);

            reader.readAsDataURL(file); // Converting file into data URL
        },
        doInsertUserDisplay (firstLoad) {
            if(firstLoad){
                this.userDisplay.name = this.user.fullName
                this.userDisplay.email = this.user.email
            }
            this.userDisplay.profilePicture = this.user.profilePicture
            this.userDisplay.dName = this.user.displayName
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
        },
        doUpdateDataUserProfile () {
            let _this = this
            if(help.isDataEmpty(_this.userDisplay.profilePicture)){
                _this.user.profilePicture = _this.userDisplay.profilePicture
            }
            console.log(_this.user.profilePicture)
            updateDataUserProfile(_this.userDisplay).then(response => {
                console.log(response)
            })
        },
        doDeleteAccount () {
            console.log('This is deleting account')
        }
    }
}
</script>
