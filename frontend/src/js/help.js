/* eslint-disable */
import moment from 'moment'

export default {
    data () {
        return {
            dmy_1: 'DD-MMM-YYYY', // 01-Mar-2018
            dmy_2: 'DD-MM-YYYY', // 01-03-2018
            dmy_3: 'YYYY/MM/DD', // 2019/02/01
        }
    },
    formatToday (format) {
        return moment().format(format)
    },
    isObjectEmpty (jsonObject) {
        if (jsonObject === null || jsonObject === undefined) return true
        else if(jsonObject > 0) return false
        return Object.keys(jsonObject).length === 0
    },
    redirectNewTab (url) {
        window.open(url, '_blank')
    }
}