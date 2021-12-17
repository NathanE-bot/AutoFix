/* eslint-disable */
import { LocalStorage } from 'quasar'
import help from '../js/help'

export default {
    isUserLogin () {
        console.log('checkUserLogin')
        if(LocalStorage.isEmpty('autoRepairUser')){
            return false
        } else {
            return true
        }
    },
    doUserLogout () {
        LocalStorage.remove('autoRepairUser')
        return LocalStorage.isEmpty('autoRepairUser')
    }
}