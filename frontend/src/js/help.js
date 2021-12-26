/* eslint-disable */
import moment from 'moment'
import router from '../router'

export default {
    data () {
        return {
            dmy_1: 'DD-MMM-YYYY', // 01-Mar-2018
            dmy_2: 'DD-MM-YYYY', // 01-03-2018
            dmy_3: 'YYYY/MM/DD', // 2019/02/01
            // Hour
            time_1: 'HH A', // 21 PM
            // Scrollbar Style
            thumbStyle: {
                right: '4px',
                borderRadius: '10px',
                backgroundColor: '#21a17b',
                width: '10px',
                opacity: 0.75
            },
            barStyle: {
                right: '2px',
                borderRadius: '10px',
                backgroundColor: '#21a17b',
                width: '10px',
                opacity: 0.2
            }
        }
    },
    defaultFormat (dateTime, format) {
        return moment(dateTime).format(format)
    },
    formatTime(time, format){
        return moment(time, "HH:mm:ss").format(format)
    },
    isObjectEmpty (jsonObject) {
        if (jsonObject === null || jsonObject === undefined) return true
        else if(jsonObject > 0) return false
        return Object.keys(jsonObject).length === 0
    },
    isDataEmpty (data) {
        if(data === undefined || data === null || data === '') return true
        return false
    },
    redirectNewTab (url) {
        window.open(url, '_blank')
    }
}
