<template>
    <q-layout class="p-bg" view="hHr LpR lFf" v-if="forLoad">
        <!-- Header -->
        <app-header />

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script>
/* eslint-disable */
import Auth from '../js/AuthValidation'
import Header from 'components/AdminWorkshopHeader'
import Swal from 'sweetalert2'

export default {
    data () {
        return {
            forLoad: true
        }
    },
    components: {
        appHeader: Header
    },
    mounted () {
        
    },
    methods: {
        changePage (url) {
            this.$router.push(url)
        }
    },
    watch: {
    '$route.path': {
        handler: function(url) {
            if(url.includes('/admin')){
                if(!Auth.isUserLogin()){
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
                } else {
                    if(Auth.userRoleType() == 'customer') {
                        this.forLoad = false
                        this.changePage('/member/your-account')
                        setTimeout(() => {
                            this.forLoad = true
                        }, 2000)
                    } else if (Auth.userRoleType() == 'workshop admin') {
                        this.forLoad = false
                        this.changePage('/admin/workshop/home')
                        setTimeout(() => {
                            this.forLoad = true
                        }, 2000)
                    }
                }
            }
        },
            deep: true,
            immediate: true
        }
    }
}
</script>
