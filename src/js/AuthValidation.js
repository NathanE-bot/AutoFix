/* eslint-disable */
import moment from 'moment'
import { LocalStorage } from 'quasar'
import help from '../js/help'

export default {
    isUserLogin () {
        if(LocalStorage.has('autoRepairUser')){
            if(!help.isDataEmpty(LocalStorage.getItem('autoRepairUser').data.access_token)){
                // var expires_in = help.defaultFormat(LocalStorage.getItem('autoRepairUser').data.expires_in, help.data().dmyhms_1) 
                // var now = help.formatToday(help.data().dmyhms_1)
                // var expired = moment(now).diff(moment(expires_in)) >= 0
                // if(expired) {
                //     LocalStorage.remove('autoRepairUser')
                //     return 'session_expired'
                // } 
                return true
            } 
            return false
        } 
        return false
    },
    userRoleType () {
        const user = LocalStorage.getItem('autoRepairUser').data.user
        if(user.role == 1){
            return 'customer'
        } else if (user.role == 2) {
            return 'workshop admin'
        } else {
            return 'insurance admin'
        }
    },
    getAccessToken () {
        if(LocalStorage.has('autoRepairUser') && !help.isDataEmpty(LocalStorage.getItem('autoRepairUser').data.access_token)){
            return LocalStorage.getItem('autoRepairUser').data.access_token
        }
        return null
    },
    getUserDetails () {
        if(LocalStorage.has('autoRepairUser') && !help.isDataEmpty(LocalStorage.getItem('autoRepairUser').data.user)){
            return LocalStorage.getItem('autoRepairUser').data.user
        }
        return {}
    },
    doUserLogout () {
        LocalStorage.remove('autoRepairUser')
        return LocalStorage.has('autoRepairUser')
    }
}