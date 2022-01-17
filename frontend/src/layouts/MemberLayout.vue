<template>
    <q-layout class="p-bg" view="hHr LpR lFf" v-if="forLoad">
        <!-- Header -->
        <app-header />

        <!-- Sidebar -->
        <div class="autorepair-sidebar" v-if="forNotInsurance">
            <app-sidebar />
        </div>
        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script>
/* eslint-disable */
import Auth from '../js/AuthValidation'
import Header from 'components/Header'
import Sidebar from 'components/Sidebar'
import Swal from 'sweetalert2'

export default {
    name: 'MemberLayout',
    data () {
        return {
            forLoad: true,
            forNotInsurance: true,
            forWorkshops: false,
            forInsurances: false
        }
    },
    components: {
        appHeader: Header,
        appSidebar: Sidebar,
    },
    mounted () {
        if(Auth.isUserLogin() == 'session_expired'){
            Swal.fire({
                icon: 'warning',
                title: 'Session expired',
                text: 'Please re-login'
            }) .then((result) => {
                if(result.isConfirmed){
                    this.changePage('/session/login')
                }
            })
        }
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
                    setTimeout(() => {
                        this.forLoad = true
                    }, 2000)
                } else {
                    this.changePage('/')
                    setTimeout(() => {
                        this.forLoad = true
                    }, 2000)
                }
            })
        }
    },
    methods: {
        changePage (url) {
            this.$router.push(url)
        }
    },
    watch: {
    '$route.path': {
        handler: function(url) {
            if(url.includes('/insurance') || url.includes('/member/workshop')){
                console.log('yes')
                this.forNotInsurance = false
            }else if(url.includes('/admin/workshop')){
                this.forWorkshops = true
                this.forNotInsurance = false
            }else if(url.includes('/admin/insurance')){
                this.forInsurances = true
                this.forNotInsurance = false
            }else{
                this.forWorkshops = false
                this.forInsurances = false
                this.forNotInsurance = true
            }
        },
            deep: true,
            immediate: true
        }
    }
}
</script>
