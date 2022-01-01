/* eslint-disable */
import { LocalStorage } from 'quasar'
import help from '../js/help'

export default {
    isUserLogin () {
        if(LocalStorage.has('autoRepairUser')) return true 
        else return false
    },
    doUserLogout () {
        LocalStorage.remove('autoRepairUser')
        return LocalStorage.has('autoRepairUser')
    }
}