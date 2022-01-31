<template>
    <q-page class="p-20">
        <div class="row">
            <div class="col-md-9 col-sm-12 d-flex a-start m-auto text-white" style="min-height:60px">
                <div class="text-h6 mr-20">Your Profile</div>
                <div v-if="isEditable">
                    <i class="fas fa-pen fs-20 edit-icon" @click="isEditable = !isEditable"></i>
                    <q-tooltip class="bg-primary text-body2 txt-white" anchor="center end" self="center start">
                        Edit Profile
                    </q-tooltip>
                </div>
                <div v-else>
                    <q-btn
                        @click="doUpdateUserData()"
                        :loading="loader"
                        type="button"
                        color="primary"
                        rounded unelevated
                        label="Save Data"
                        class="tf-capitalize m-0"
                    >
                    </q-btn>
                    <q-btn
                        @click="isEditable = !isEditable; doInsertUserDisplay(false)"
                        color="negative"
                        rounded unelevated
                        label="Discard"
                        class="tf-capitalize m-0 ml-10-i"
                    >
                    </q-btn>
                </div>
            </div>
            <div class="row col-md-12 col-sm-12 flex flex-center">
                <div class="d-flex flex-dir-col a-start mr-30">
                    <q-avatar class="bg-white relative-position m-auto" size="180px">
                        <!-- <q-badge v-if="!help.isDataEmpty(userDisplay.image) && !isEditable" class="discardDP cursor-pointer" rounded color="red" @click="doClearImage()">X</q-badge> -->
                        <img :class="['responsive_img fit-content', {'z-opacity w-0-i' : help.isDataEmpty(userDisplay.image)}]" :src="userDisplay.image" id="myImg">
                        <i v-if="help.isDataEmpty(userDisplay.image)" class="fas fa-user grey-5"></i>
                        <q-btn icon="fas fa-pen" fab-mini class="edit-img-btn cursor-pointer" text-color="white" color="secondary" v-if="!isEditable">
                            <div class="input-hide">
                                <input class="cursor-pointer" type="file" accept=".png,.jpg,.jpeg" id="uploadDPUser" @change="doUploadProfilePicture($event)">
                            </div>
                        </q-btn>
                    </q-avatar>
                    <div class="text-white my-20" style="max-width: 240px">
                        File size: Maximum file size 10 Megabytes. Allowed file extensions: .JPG .PNG .JPEG
                    </div>
                    <q-btn
                        @click="doRequestForgotPasswordEmail()"
                        :loading="loader"
                        unelevated rounded color="primary"
                        label="Change Password"
                        class="tf-capitalize fw"
                    />
                </div>
                <div class="input-outline-profile q-gutter-y-lg col-md-6 col-sm-12">
                    <div>
                        <span>Email</span>
                        <q-input v-model="userDisplay.email" outlined disable dense />
                    </div>
                    <div>
                        <span>Name</span>
                        <q-input v-model="userDisplay.name" outlined disable dense />
                    </div>
                    <div>
                        <span>Date of Birth</span>
                        <q-input v-model="userDisplay.DoB" outlined dense :disable="isEditable" />
                    </div>
                    <div>
                        <span>Display Name</span>
                        <q-input v-model="userDisplay.displayName" outlined dense :disable="isEditable" />
                    </div>
                    <div>
                        <span>Phone Number</span>
                        <q-input v-model="userDisplay.phoneNumber" outlined dense :disable="isEditable" />
                    </div>
                </div>
                <div class="input-outline-profile mt-30 col-md-9">
                    <div>
                        <span class="primary_color text-h6">Address</span>
                        <q-input v-model="userDisplay.address" outlined type="textarea" :disable="isEditable" class="fix-txt-field" />
                    </div>
                </div>
                <div class="col-md-9 j-end mt-20">
                    <q-btn color="negative" unelevated rounded class="tf-capitalize d-flex" @click="doDeleteAccount()" label="Delete Account" />
                </div>
            </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { requestForgotPasswordEmail } from '../../api/loginRegisterServices'
import { updateDataUserProfile, saveImgTest } from '../../api/UserService'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import Swal from 'sweetalert2'

export default {
    data () {
        return{
            help,
            loader: false,
            loader: false,
            tes: 0,
            user: {},
            userDisplay: {
                id: null,
                displayName: null,
                name: null,
                email: null,
                phoneNumber: null,
                DoB: null,
                image: null,
                address: null,
            },
            isEditable: true
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doInsertUserDisplay(true)
    },
    methods: {
        doClearImage () {
            this.userDisplay.image = null
            document.getElementById('uploadDPUser').value = ''
        },
        doUploadProfilePicture (event) {
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
            } else {
                var reader = new FileReader() // Creating reader instance from FileReader() API

                var preview = document.getElementById('myImg') // Image reference
                var file = inputFile[0] // File refrence

                reader.addEventListener("load", function () { // Setting up base64 URL on image
                    preview.src = reader.result
                }, false)
                reader.readAsDataURL(file)

                const formData = new FormData
                formData.set('image', file)
                this.userDisplay.image = formData
            }
        },
        doUpdateUserData(){
            this.loader = true
            if(typeof this.userDisplay.image !== 'object'){
                this.doUpdateDataUserProfile()
            } else {
                saveImgTest(this.userDisplay.image, this.user.id).then(response => {
                    console.log(response.data)
                    this.doUpdateDataUserProfile()
                }) .catch(function (error) {
                    this.loader = false
                    console.log(error.response)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.response.data
                    })
                })
            }
        },
        doInsertUserDisplay (firstLoad) {
            if(firstLoad){
                this.userDisplay.id = this.user.id
                this.userDisplay.name = this.user.fullName
                this.userDisplay.email = this.user.email
            }
            if(this.userDisplay.image == null){
                this.userDisplay.image = ''
            }
            this.userDisplay.image = this.user.profilePicture
            this.userDisplay.displayName = this.user.displayName
            this.userDisplay.phoneNumber = this.user.phoneNumber
            this.userDisplay.DoB = help.defaultFormat(this.user.DoB, help.data().dmy_7)
            this.userDisplay.address = this.user.address
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
            _this.$q.loading.show({})
            if(help.isDataEmpty(_this.userDisplay.image)){
                _this.userDisplay.image = null
            }
            _this.userDisplay.DoB = help.defaultFormat(_this.userDisplay.DoB, help.data().dmy_5)
            updateDataUserProfile(_this.userDisplay).then(response => {
                console.log(response.data)
                let tempLocalStorage = {}
                tempLocalStorage = LocalStorage.getItem('autoRepairUser')
                tempLocalStorage.data.user = response.data
                LocalStorage.remove('autoRepairUser')
                LocalStorage.set('autoRepairUser', tempLocalStorage)
                _this.user = LocalStorage.getItem('autoRepairUser').data.user
                _this.doInsertUserDisplay(false)
                _this.loader = false
                _this.$q.loading.hide()
                _this.$router.go()
            }) .catch(function (error) {
                _this.loader = false
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data
                })
            })
        },
        doDeleteAccount () {
            console.log('This is deleting account')
        }
    }
}
</script>
