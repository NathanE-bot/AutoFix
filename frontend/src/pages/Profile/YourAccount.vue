<template>
    <q-page class="p-20">
        <q-form @submit.prevent="doUpdateUserData" class="row">
            <div class="col-md-9 col-sm-12 d-flex a-baseline m-auto text-white" style="min-height:60px">
                <div class="text-h6 mr-20">Your Profile</div>
                <q-btn
                    v-if="isEditable"
                    @click="isEditable = !isEditable"
                    icon="fas fa-pen" flat round :loading="loader" :disable="cpLoader"
                    class="edit-pen-btn edit-pen-btn-active"
                    >
                        <q-tooltip
                            class="text-body2 txt-white bg-primary"
                            anchor="center left" self="center end" :offset="[10, 0]">
                            Edit Profile
                        </q-tooltip>
                </q-btn>
                <div v-else>
                    <q-btn
                        :loading="loader" :disable="cpLoader"
                        type="submit"
                        color="primary"
                        rounded unelevated
                        label="Save Data"
                        class="tf-capitalize m-0"
                    >
                    </q-btn>
                    <q-btn
                        @click="isEditable = !isEditable; doInsertUserDisplay(false)"
                        color="negative" :disable="cpLoader || loader"
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
                        <q-btn icon="fas fa-pen" fab-mini class="edit-img-btn" text-color="white" color="secondary" v-if="!isEditable" :disable="cpLoader || loader">
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
                        :loading="cpLoader" :disable="isEditable || loader"
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
                        <q-input v-model="DoBForDisplay" type="text" class="icon-hover-input-white" readonly outlined dense :disable="isEditable || cpLoader || loader">
                            <q-tooltip
                                class="text-body2 txt-white bg-primary"
                                anchor="center end" self="center start" :offset="[10, 0]">
                                Change Date
                            </q-tooltip>
                            <template v-slot:append>
                                <q-icon name="event" class="cursor-pointer">
                                    <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                                        <q-date v-model="DoBForProxy">
                                        <div class="row items-center justify-end">
                                            <q-btn v-close-popup label="Close" no-caps color="primary" flat />
                                        </div>
                                        </q-date>
                                    </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                    </div>
                    <div>
                        <span>Display Name</span>
                        <q-input v-model="userDisplay.displayName" outlined dense :disable="isEditable || cpLoader || loader" />
                    </div>
                    <div>
                        <span>Phone Number</span>
                        <q-input v-model="userDisplay.phoneNumber" :rules="rules.phoneNumber_r" mask="############" lazy-rules="ondemand" outlined dense :disable="isEditable || cpLoader || loader" />
                    </div>
                </div>
                <div class="input-outline-profile mt-30 col-md-9">
                    <div>
                        <span class="primary_color text-h6">Address</span>
                        <q-input v-model="userDisplay.address" outlined type="textarea" :disable="isEditable || cpLoader || loader" class="fix-txt-field" />
                    </div>
                </div>
                <div class="col-md-9 j-end mt-20">
                    <!-- <q-btn color="negative" unelevated rounded class="tf-capitalize d-flex" @click="doDeleteAccount()" :loading="loader" label="Delete Account" /> -->
                </div>
            </div>
        </q-form>
    </q-page>
</template>

<script>
/* eslint-disable */
import { requestForgotPasswordEmail } from '../../api/loginRegisterServices'
import { updateDataUserProfile, saveImgTest, deleteUserAccount } from '../../api/UserService'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import Auth from '../../js/AuthValidation'
import Swal from 'sweetalert2'

export default {
    data () {
        return{
            help,
            loader: false,
            cpLoader: false,
            tes: 0,
            user: {},
            userToken: null,
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
            rules: {
                phoneNumber_r: [
                    v => !!v || 'Phone number is required!',
                    v => /^[0-9]{10,12}$/.test(v) || 'Minimal of 10 digit'
                ]
            },
            DoBForDisplay: null,
            DoBForProxy: null,
            isEditable: true,
            isUploadPhoto: false
        }
    },
    created () {
        this.user = Auth.getUserDetails()
        this.userToken =  Auth.getAccessToken()
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
            if(typeof this.userDisplay.image !== 'object' || help.isDataEmpty(this.userDisplay.image)){
                this.doUpdateDataUserProfile()
            } else {
                saveImgTest(this.userDisplay.image, this.user.id, this.userToken).then(response => {
                    console.log(response.data)
                    this.isUploadPhoto = true
                    this.doUpdateDataUserProfile()
                }) .catch(function (error) {
                    this.loader = false
                    console.log(error.response)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.response.message,
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'br-25px-i py-5-i px-20-i'
                        }
                    })
                })
            }
        },
        doInsertUserDisplay (firstLoad) {
            this.loader = true
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
            this.DoBForDisplay = help.defaultFormat(this.user.DoB, help.data().dmy_8)
            this.DoBForProxy = help.defaultFormat(this.user.DoB, help.data().dmy_3)
            this.userDisplay.address = this.user.address
            this.loader = false
        },
        doRequestForgotPasswordEmail () {
            let _this = this
            _this.cpLoader = true
            requestForgotPasswordEmail(_this.user).then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message,
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'br-25px-i py-5-i px-20-i'
                    }
                }) .then((result) => {
                    if(result.isConfirmed){
                        _this.cpLoader = false
                    }
                })
            }) .catch(function (error) {
                console.log(error.response)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.email,
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'br-25px-i py-5-i px-20-i'
                    }
                })
                _this.cpLoader = false
            })
        },
        doUpdateDataUserProfile () {    
            let _this = this
            if(help.isDataEmpty(_this.userDisplay.image)){
                _this.userDisplay.image = null
            }
            _this.userDisplay.DoB = help.defaultFormat(_this.DoBForDisplay, help.data().dmy_5)
            updateDataUserProfile(_this.userDisplay, _this.userToken).then(response => {
                console.log(response.data)
                let tempLocalStorage = {}
                tempLocalStorage = LocalStorage.getItem('autoRepairUser')
                tempLocalStorage.data.user = response.data
                LocalStorage.remove('autoRepairUser')
                LocalStorage.set('autoRepairUser', tempLocalStorage)
                _this.user = LocalStorage.getItem('autoRepairUser').data.user
                _this.doInsertUserDisplay(false)
                _this.loader = false
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Your account has been updated.',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'br-25px-i py-5-i px-20-i'
                    }
                }) .then(() => {
                    _this.isEditable = !_this.isEditable
                    if(_this.isUploadPhoto){
                        _this.$router.go()
                    }
                })
            }) .catch(function (error) {
                console.log(error.response.data.id)
                _this.loader = false
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.id == 1 ? 'Input format error, please check again.' : 'Please contact our admin'
                })
            })
        },
        doDeleteAccount () {
            let _this = this
            Swal.fire({
                icon: 'warning',
                title: 'Attention!',
                text: 'This will delete your account and cannot be restored, proceed?',
                confirmButtonText: 'Delete Account',
                confirmButtonColor: '#d32f2f',
                showCancelButton: true,
                cancelButtonText: 'Cancel'
            }) .then((result) => {
                if(result.isConfirmed){
                    _this.loader = true
                    deleteUserAccount(_this.user.id, _this.userToken).then(response => {
                        console.log(response.data)
                        _this.loader = false
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Your account has been deleted.'
                        }) .then(() => {
                            if(!Auth.doUserLogout()){
                                _this.loader = false
                                _this.changePage('/')
                            }
                        })
                    }) .catch((error) => {
                        _this.loader = false
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response.data
                        })
                    })
                } else {
                    _this.loader = false
                }
            }) .catch((error) => {
                _this.loader = false
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data
                })          
            }) 
        },
        changePage(url){
            this.$router.push(url)
        }
    },
    watch: {
        DoBForProxy: {
            handler(v) {
                this.DoBForDisplay = help.defaultFormat(v, help.data().dmy_8)
            }
        }
    }
}
</script>
