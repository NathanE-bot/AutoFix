<template>
    <q-layout class="p-bg" view="hHr LpR lFf" v-if="forLoad">
        <!-- Header -->
        <app-header />

        <!-- Sidebar -->
        <div class="autorepair-sidebar" v-if="isOnDetailSchedule">
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
            isOnDetailSchedule: true
        }
    },
    components: {
        appHeader: Header,
        appSidebar: Sidebar,
    },
    methods: {
        changePage (url) {
            this.$router.push(url)
        }
    },
    watch: {
        '$route.path': {
            handler: function(url) {
                if(Auth.isUserLogin()){
                    if(Auth.userRoleType() == 'customer'){
                        if(url.includes('/workshop/') || url.includes('/insurance/')){
                            this.isOnDetailSchedule = false
                        } else if(url.includes('/member')){
                            this.isOnDetailSchedule = true
                        }
                    } else if (Auth.userRoleType() == 'workshop admin'){
                        this.forLoad = false
                        this.changePage('/admin/workshop/home')
                        setTimeout(() => {
                            this.forLoad = true
                        }, 2000)
                    } else {
                        this.forLoad = false
                        this.changePage('/admin/insurance/home')
                        setTimeout(() => {
                            this.forLoad = true
                        }, 2000)
                    } 
                } else if (!Auth.isUserLogin() && url.includes('/session/')) {
                    this.forLoad = false
                } else if (!Auth.isUserLogin() && !url.includes('/session/') && !url.includes('/insurance/') && !url.includes('/member/') && !url.includes('/admin/')) {
                    this.forLoad = false
                }
                else {
                    this.forLoad = false
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
            deep: true,
            immediate: true
        }
    }
}
</script>
