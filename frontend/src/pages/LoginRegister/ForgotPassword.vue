<template>
    <q-page class="flex flex-center">
        <q-card class="my-card forgotpass-card w-50">
            <q-card-section class="p-35">
                <div class="position-relative">
                    <img class="responsive_img logo_topRight" width="120" src="~assets/images/logo.png" alt="">
                </div>
                <h4 class="mt-0 mb-20 fw-bold">Forgot Password</h4>
                <span class="text-subtitle2">Please insert your email address</span>
            </q-card-section>
            <q-card-section class="p-35 pt-0">
                <q-form
                  @submit.prevent.stop="doRequestForgotPasswordEmail"
                  class="w-95 m-auto"
                >
                    <q-input
                        v-model="form.email"
                        :rules="rules.email_r" lazy-rules="ondemand"
                        type="email"
                        label="Email"
                        borderless
                        class="default-input-1"
                    >
                        <template v-slot:prepend>
                            <q-icon name="email" />
                        </template>
                    </q-input>
                    <div class="mt-20 d-flex">
                        <q-btn
                            :loading="loader"
                            class="tf-capitalize"
                            padding="6px 32px"
                            rounded unelevated
                            type="submit"
                            label="Send"
                            color="primary"
                        />
                    </div>
                </q-form>
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
            }
        }
    },
    methods: {
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
                    text: error.response.data.message
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
