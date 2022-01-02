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
import { Route } from 'vue-router'

export default {
    name: 'MemberLayout',
    data () {
        return {
            forLoad: true,
            forNotInsurance: true
        }
    },
    components: {
        appHeader: Header,
        appSidebar: Sidebar
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
    },
    watch: {
    '$route.path': {
        handler: function(url) {
            if(url.includes('/insurance') || url.includes('/workshop/member')){
                console.log('yes')
                this.forNotInsurance = false
            } else {
                this.forNotInsurance = true
            }
        },
            deep: true,
            immediate: true
        }
    }
}
</script>
