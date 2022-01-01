<template>
    <q-page class="insurance_layout_1 flex flex-center position-relative" v-if="forLoad">
        <div>
            <img class="responsive-img" src="~assets/images/preset/image1.png" alt="">
        </div>
        <div class="m-auto text-center">
            <h4 class="fw-bold">Choose Your Insurance</h4>
            <q-select
                v-model="model"
                :options="options"
                class="insurance_select"
                standout="bg-primary text-white"
                label="Choose your type of insurance"
                transition-show="jump-down"
                transition-hide="jump-up" />
            <q-btn
                @click="changePage('/member/insurance/form')"
                color="primary"
                size="xl" unelevated
                icon="fas fa-check"
                class="br-10px mt-20 q-px-lg q-py-xs" />
        </div>
        <div>
            <img class="responsive-img" src="~assets/images/preset/image2.png" alt="">
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import Auth from '../../js/AuthValidation'
import Swal from 'sweetalert2'
import help from '../../js/help'
export default {
    data () {
        return {
            help,
            model: null,
            options: [
                'Testing1', 'Testing2', 'Testing3'
            ]
        }
    },
    mounted () {
        if(!Auth.isUserLogin()){
            this.forLoad = false
            console.log('tes')
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
                    this.forLoad = true
                } else {
                    this.changePage('/')
                    setTimeout(() => {
                        this.forLoad = true
                    }, 500)
                }
            })
        }
    },
    methods: {
        changePage (url) {
            this.$router.push(url)
        }
    }
}
</script>
