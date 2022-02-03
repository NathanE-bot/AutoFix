<template>
    <q-page class="flex flex-center">
        <q-card class="my-card forgotpass-card w-75" :style="{height: window.heightAltered + 'px'}">
            <q-card-section class="p-35 flex flex-center">
                <div class="position-relative">
                    <img class="responsive_img fit-content logo_topLeft" width="150" src="~assets/images/logo.png" alt="">
                </div>
                <div class="position-relative">
                    <q-btn
                        @click="changePage('/session/login')"
                        unelevated round outline
                        size="lg"
                        class="back-btn_topRight"
                    >
                        <i class="fas fa-chevron-left fs-35"></i>
                    </q-btn>
                    <!-- <span>Back</span> -->
                </div>
                <div style="width:100%">
                    <div class="text-align-center">
                        <h4 class="mt-0 mb-20 fw-blackbold fs-40 w-50 m-auto">Input Your Email For Verification</h4>
                    </div>
                    <div class="mt-50">
                        <q-form
                        @submit.prevent.stop="doRequestForgotPasswordEmail"
                        class="fw m-auto"
                        >
                            <q-input
                                v-model="form.email"
                                :rules="rules.email_r" lazy-rules="ondemand"
                                type="email"
                                label="Email"
                                borderless
                                class="default-input-1 w-50 m-auto"
                            >
                                <template v-slot:prepend>
                                    <q-icon name="email" />
                                </template>
                            </q-input>
                            <div class="mt-20 d-flex flex-center">
                                <q-btn
                                    :loading="loader"
                                    class="tf-capitalize br-20px w-50 fw-bold fs-20"
                                    padding="12px 32px"
                                    rounded outline
                                    type="submit"
                                    label="Send Email"
                                    color="primary"
                                />
                            </div>
                        </q-form>
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script>
/* eslint-disable */
import { requestForgotPasswordEmail } from '../../api/loginRegisterServices'
import Swal from 'sweetalert2'

export default {
    data () {
        return {
            loader: false,
            form: {
                email: ''
            },
            rules: {
                email_r: [
                    v => !!v || 'Email Harus Diisi',
                    v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Format Email Salah'
                ]
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
    methods: {
        handleResize () {
            this.window.width = window.innerWidth
            this.window.height = window.innerHeight
            this.window.heightAltered = window.innerHeight - (window.innerHeight * (18/100))
        },
        doRequestForgotPasswordEmail () {
            let _this = this
            _this.loader = true
            requestForgotPasswordEmail(_this.form).then(response => {
                _this.form.email = ''

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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.email
                })
                _this.loader = false
            })
        },
        changePage (url) {
            this.$router.push(url)
        }
    }
}
</script>
