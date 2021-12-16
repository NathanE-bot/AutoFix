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
export default {
    name: 'LoginRegisterLayout',
    data () {
        return {
        }
    },
    mounted () {
        if(!Auth.isUserLogin){
            this.changePage('/')
        }
    },
    methods: {
        changePage (url) {
            console.log('here')
            this.$router.push(url)
        }
    }
}
</script>
