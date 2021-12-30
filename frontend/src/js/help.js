/* eslint-disable */
import moment from 'moment'
import router from '../router'

export default {
    data () {
        return {
            // Day Month Year
            dmy_1: 'DD-MMM-YYYY', // 01-Mar-2018
            dmy_2: 'DD-MM-YYYY', // 01-03-2018
            dmy_3: 'YYYY/MM/DD', // 2019/02/01
            dmy_4: 'y-M-D', // 2019-02-01
            dmy_5: 'YYYY-MM-DD', // 2019-02-01
            // Day
            d_1: 'dddd', //Sunday
            // Hour
            time_1: 'HH A', // 21 PM
            time_2: 'HH:mm', // 21:20
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
    formatTodayFormatter (today) {
        console.log(today)
        if (today == 'monday') {
            return today = '1'
        } else if (today == 'tuesday') {
            return today = '2'
        } else if (today == 'wednesday') {
            return today = '3'
        } else if (today == 'thursday') {
            return today = '4'
        } else if (today == 'friday') {
            return today = '5'
        } else if (today == 'saturday') {
            return today = '6'
        } else if (today == 'sunday') {
            return today = '0'
        }
    },
    formatToday (format) {
        return moment().format(format)
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
