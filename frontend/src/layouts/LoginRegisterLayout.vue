<template>
    <q-layout view="hHr LpR lFf">
        <q-page-container class="log-reg-s">
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script>
/* eslint-disable */
import Auth from '../js/AuthValidation'
import help from '../js/help'

export default {
    name: 'LoginRegisterLayout',
    data () {
        return {
            currentRouteName: this.$router.currentRoute._value.fullPath
        }
    },
    mounted () {
        if(Auth.isUserLogin() && !this.currentRouteName.includes('/forgotpassword') && !this.currentRouteName.includes('/resetpassword')){
            this.changePage('/')
        }
    },
    methods: {
        changePage (url) {
            this.$router.push(url)
        }
    }
}
</script>
