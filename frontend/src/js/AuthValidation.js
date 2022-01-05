/* eslint-disable */
import moment from 'moment'
import { LocalStorage } from 'quasar'
import help from '../js/help'

export default {
    isUserLogin () {
        if(LocalStorage.has('autoRepairUser')){
            if(LocalStorage.getItem('autoRepairUser').data.access_token){
                var expires_in = help.defaultFormat(LocalStorage.getItem('autoRepairUser').data.expires_in, help.data().dmyhms_1) 
                var now = help.formatToday(help.data().dmyhms_1)
                var expired = moment(now).diff(moment(expires_in)) >= 0
                if(expired) {
                    LocalStorage.remove('autoRepairUser')
                    return 'session_expired'
                } 
                return true
            } 
            else return false
        } 
        else return false
    },
    doUserLogout () {
        LocalStorage.remove('autoRepairUser')
        return LocalStorage.has('autoRepairUser')
    }
}