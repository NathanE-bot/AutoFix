<template>
    <q-page class="flex flex-center">
        <q-card class="w-60 py-60 br-20px position-relative flex flex-center" :style="{height: window.heightAltered + 'px'}">
            <div class="position-relative">
                <img class="responsive_img fit-contentlogo_topLeft" width="150" src="~assets/images/logo.png" alt="">
            </div>
            <q-card-section class="flex flex-center flex-dir-col" v-if="!help.isDataEmpty(email)">
                <h5 class="my-10">We've sent you a 4 digits verification code for your account at,</h5>
                <h5 class="my-10 mb-20 fw-blackbold">{{ email }}</h5>
                <div :class="['d-flex a-center', {'mb-40' : !errorMessage}]">
                    <q-input @keyup="otpChangeIndex(2, $event, otp1)" class="otp-input otp_1" outlined maxlength="1" v-model="otp1" />
                    <span class="mx-15">-</span>
                    <q-input @keyup="otpChangeIndex(3, $event, otp2)" class="otp-input otp_2" outlined maxlength="1" v-model="otp2" />
                    <span class="mx-15">-</span>
                    <q-input @keyup="otpChangeIndex(4, $event, otp3)" class="otp-input otp_3" outlined maxlength="1" v-model="otp3" />
                    <span class="mx-15">-</span>
                    <q-input class="otp-input otp_4" outlined maxlength="1" v-model="otp4" />
                </div>
                <div>
                    <q-btn @click="doFinalOtp()" label="Verify Code" padding="10px 32px" outline color="primary" class="br-15px fw-bold tf-capitalize mb-20"></q-btn>
                </div>
                <span v-if="errorMessage" class="red-txt text-subtitle2 fw-semibold mt-15">Kode OTP belum valid</span>
                <div v-if="failed">
                    <span v-if="timerVisible" class="slate_grey">Resend in {{ timerCount }}</span>
                    <span v-else class="link_txt slate_grey" @click="doResendOtp()">Resend Otp?</span>
                </div>
            </q-card-section>
            <q-card-section v-else class="flex flex-center flex-dir-col">
                <h5 class="my-10">You are not authorized in this page.</h5>
            </q-card-section>
        </q-card>
    </q-page>
</template>
<script>
/* eslint-disable */
import help from '../../js/help'
import { getTempUserID, verififcationEmailWithOtp, resendOtp } from '../../api/loginRegisterServices'
import Swal from 'sweetalert2'

export default {
    data () {
        return {
            help,
            loader: false,
            errorMessage: false,
            failed: false,
            timerVisible: true,
            otp1: null,
            otp2: null,
            otp3: null,
            otp4: null,
            otpFinal: null,
            encryptUserId: null,
            email: '',
            timerCount: 30,
            timerCountOriginal: 30,
            window: {
                width: 0,
                height: 0,
                heightAltered: 0
            }
        }
    },
    mounted () {
        window.addEventListener('resize', this.handleResize)
        this.handleResize()
    },
    unmounted () {
        window.removeEventListener('resize', this.handleResize)
    },
    created () {
        this.encryptUserId = this.$route.params.id
        this.doGetTempUserID()
    },
    methods: {
        handleResize () {
            this.window.width = window.innerWidth
            this.window.height = window.innerHeight
            this.window.heightAltered = window.innerHeight - (window.innerHeight * (18/100))
        },
        doResendOtp () {
            let _this = this
            _this.resendLoader = true
            _this.timerCountOriginal = _this.timerCountOriginal + _this.timerCountOriginal
            if(_this.timerCountOriginal > 60) _this.timerCountOriginal = 60
            _this.timerCount = _this.timerCountOriginal
            _this.timerVisible = true
            resendOtp(_this.email, _this.encryptUserId).then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message
                })
                _this.resendLoader = false
            }) .catch(function (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message
                })
                _this.resendLoader = false
            })
        },
        doGetTempUserID () {
            let _this = this
            _this.loader = true
            getTempUserID(_this.encryptUserId).then(response => {
                _this.email = response.data.email
                _this.loader = false
            }) .catch(function (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message
                })
                _this.loader = false
            })
        },
        otpChangeIndex (index, event, value) {
            if(index <= 4 && event.code !== 'Backspace' && !isNaN(value) && !help.isDataEmpty(value)) {
                setTimeout(() => {
                    document.getElementsByClassName("otp_" + index)[0].focus()
                }, 0)
            }
        },
        doFinalOtp () {
            this.otpFinal = this.otp1 + this.otp2 + this.otp3 + this.otp4
            if(!isNaN(this.otpFinal)){
                console.log('ini angka')
            } else {
                this.otpFinal = null
                console.log('invalid')
            }
            if(!help.isDataEmpty(this.otp1) && !help.isDataEmpty(this.otp2) && !help.isDataEmpty(this.otp3) && !help.isDataEmpty(this.otp4)){
                this.doVerififcationEmailWithOtp()
            }
        },
        doVerififcationEmailWithOtp () {
            let _this = this
            _this.loader = true
            _this.errorMessage = false
            if(help.isDataEmpty(this.otpFinal)){
                _this.errorMessage = true
            } else {
                verififcationEmailWithOtp(_this.otpFinal, _this.encryptUserId).then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message
                    }) .then((result) => {
                        if(result.isConfirmed){
                            _this.changePage('/session/login')
                            _this.loader = false
                        }
                    })
                }) .catch(function (error) {
                    _this.otp1 = null
                    _this.otp2 = null
                    _this.otp3 = null
                    _this.otp4 = null
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.response.data.message
                    }) .then((result) => {
                        if(result.isConfirmed){
                           _this.doStartTimer()
                        }
                    })
                _this.loader = false
                })
            }
           
        },
        doStartTimer () {
            this.failed = true
            this.timerCount--
        },
        changePage (url) {
            this.$router.push(url)
        },
        doConsole (a) {
            console.log(a)
        }
    },
    watch: {
        timerCount: {
            handler(value) {
                if(this.failed){
                    if (value > 0) {
                        setTimeout(() => {
                            this.timerCount--
                        }, 1000)
                    } else {
                        this.timerVisible = false
                    }
                }
            }
        }
    }
}
</script>
