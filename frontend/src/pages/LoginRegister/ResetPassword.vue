<template>
    <q-page class="flex flex-center" v-if="pageLodaer">
        <q-card class="my-card forgotpass-card w-75" :style="{height: window.heightAltered + 'px'}">
            <div class="position-relative">
                <img class="responsive_img fit-content logo_topLeft" width="150" src="~assets/images/logo.png" alt="">
            </div>
            <q-card-section class="p-35 flex flex-center">
                <div style="width: 100%">
                    <div class="text-align-center mb-30">
                        <h4 class="mt-0 mb-20 fw-blackbold fs-40 w-50 m-auto">Reset Your Password</h4>
                    </div>
                    <q-form
                    @submit.prevent.stop="doResetUserPassword"
                    class="w-40 m-auto"
                    >
                        <q-input
                            v-model="form.password"
                            :rules="rules.password_r" lazy-rules="ondemand"
                            :type="isPwd ? 'password' : 'text'"
                            label="Password"
                            borderless
                            class="col-md-12 default-input-1"
                        >
                            <template v-slot:prepend>
                                <q-icon name="lock" />
                            </template>
                        </q-input>
                        <q-input
                            v-model="form.password_confirmation"
                            :rules="rules.password_confirmation_r" lazy-rules="ondemand"
                            :type="isPwd ? 'password' : 'text'"
                            label="Password Confirmation"
                            borderless
                            class="col-md-12 default-input-1"
                        >
                            <template v-slot:prepend>
                                <q-icon name="lock" />
                            </template>
                            <template v-slot:append>
                                <q-icon
                                :name="isPwd ? 'visibility_off' : 'visibility'"
                                class="cursor-pointer"
                                @click="isPwd = !isPwd"
                                />
                            </template>
                        </q-input>
                        <div class="mt-20 d-flex j-center">
                            <q-btn
                                :loading="loader"
                                class="tf-capitalize"
                                padding="6px 32px"
                                rounded unelevated
                                type="submit"
                                label="Reset Password"
                                color="primary"
                            />
                        </div>
                    </q-form>
                </div>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script>
/* eslint-disable */
import help from '../../js/help'
import Swal from 'sweetalert2'
import { resetUserPassword } from '../../api/loginRegisterServices'

export default {
    data () {
        return {
            help,
            loader: false,
            pageLodaer: true,
            isPwd: true,
            form: {
                token: null,
                password: '',
                password_confirmation: ''
            },
            rules: {
                password_r: [
                    v => !!v || 'Password harus diisi',
                    v => v.length >= 8 || 'Password minimal 8 karakter'
                ],
                password_confirmation_r: [
                    v => !!v || 'Password harus diisi',
                    v => v === this.form.password || 'Password belum sama'
                ],
            },
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
        this.form.token = this.$route.params.id
        this.doCheckTokenIdFromURL()
    },
    methods: {
        handleResize () {
            this.window.width = window.innerWidth
            this.window.height = window.innerHeight
            this.window.heightAltered = window.innerHeight - (window.innerHeight * (18/100))
        },
        doCheckTokenIdFromURL () {
            if(help.isDataEmpty(this.form.token)){
                this.pageLodaer = false
                setTimeout(() => {
                    this.changePage('/')
                    this.pageLodaer = true
                }, 3000)
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'You are not authorized in this page. Press Ok or you will automatically redirected you to landing page in 3 seconds.'
                }) .then((result) => {
                    if(result.isConfirmed){
                        this.changePage('/')
                        this.pageLodaer = true
                    }
                })
            }
        },
        doResetUserPassword () {
            let _this = this
            _this.loader = true
            resetUserPassword(_this.form).then(response => {
                console.log(response)
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message
                }) .then((result) => {
                    if(result.isConfirmed){
                        this.changePage('/session/login')
                        this.loader = false
                    }
                })
                _this.loader = false
            }) .catch(function (error) {
                _this.loader = false
                Swal.fire({
                    icon: error.response.data.id === 4 ? 'warning' : 'error',
                    title: 'Error',
                    text: error.response.data.message
                })
            })
        },
        changePage (url) {
            this.$router.push(url)
        }
    }
}
</script>