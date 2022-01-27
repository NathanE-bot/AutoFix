<template>
    <q-layout class="p-bg" view="hHr LpR lFf" v-if="forLoad">
        <!-- Header -->
        <app-header />

        <!-- Sidebar -->
        <div class="autorepair-sidebar">
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
            forLoad: true
        }
    },
    components: {
        appHeader: Header,
        appSidebar: Sidebar,
    },
    mounted () {
        // if(!Auth.isUserLogin()){
        //     this.forLoad = false
        //     Swal.fire({
        //       title: 'Error',
        //       text: 'Please login first.',
        //       confirmButtonText: 'Login',
        //       confirmButtonColor: '#21a17b',
        //       showCancelButton: true,
        //       cancelButtonText: 'Back',
        //     }) .then((result) => {
        //         if(result.isConfirmed){
        //             this.changePage('/session/login')
        //             setTimeout(() => {
        //                 this.forLoad = true
        //             }, 2000)
        //         } else {
        //             this.changePage('/')
        //             setTimeout(() => {
        //                 this.forLoad = true
        //             }, 2000)
        //         }
        //     })
        // } else {
        //     if(Auth.userRoleType() !== 'customer'){
        //         this.forLoad = false
        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Unauthorized',
        //             text: 'Your are not authorized in this page, redirecting you to another page.',
        //             allowOutsideClick: () => {
        //                 const popup = Swal.getPopup()
        //                 popup.classList.remove('swal2-show')
        //                 setTimeout(() => {
        //                     popup.classList.add('animate__animated', 'animate__headShake')
        //                 })
        //                 setTimeout(() => {
        //                     popup.classList.remove('animate__animated', 'animate__headShake')
        //                 }, 500)
        //                 return false
        //             }
        //         }) .then((result) => {
        //             if(result.isConfirmed && Auth.userRoleType() == 'workshop admin'){
        //                 this.changePage('/admin/workshop/home')
        //                 setTimeout(() => {
        //                     this.forLoad = true
        //                 }, 2000)
        //             } else if (result.isConfirmed && Auth.userRoleType() == 'insurance admin'){
        //                 this.changePage('/admin/insurance/home')
        //                 setTimeout(() => {
        //                     this.forLoad = true
        //                 }, 2000)
        //             }
        //         })
        //     }
        // }
    },
    methods: {
        changePage (url) {
            this.$router.push(url)
        }
    },
    watch: {
    '$route.path': {
        handler: function(url) {
            if(url.includes('/member')){
                if(!Auth.isUserLogin()){
                    this.forLoad = false
                    console.log('member one')
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
            }
        },
            deep: true,
            immediate: true
        }
    }
}
</script>
