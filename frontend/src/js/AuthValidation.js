/* eslint-disable */
import { LocalStorage } from 'quasar'
import help from '../js/help'

export default {
    isUserLogin () {
        console.log('cek', LocalStorage.has('autoRepairUser'))
        if(LocalStorage.has('autoRepairUser')) return true 
        else return false
    },
    doUserLogout () {
        LocalStorage.remove('autoRepairUser')
        return LocalStorage.has('autoRepairUser')
    }
}