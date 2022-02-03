/* eslint-disable */
import moment from 'moment'
import { createNamespacedHelpers } from 'vuex'
import router from '../router'

const localURL = 'http://127.0.0.1:8000'
const vcpURL = 'https://34.126.189.122'
const vcpURLBackend = 'https://34.126.189.122:8080'

export default {
    data () {
        return {
            // Day Month Year Hour Min Sec
            dmyhms_1: 'YYYY-MM-DDTHH:MM:SS', // 2021-01-12T12:40:64
            // Day Month Year
            dmy_1: 'DD-MMM-YYYY', // 01-Mar-2018
            dmy_2: 'DD-MM-YYYY', // 01-03-2018
            dmy_3: 'YYYY/MM/DD', // 2019/02/01
            dmy_4: 'y-M-D', // 2019-02-01
            dmy_5: 'YYYY-MM-DD', // 2019-02-01
            dmy_6: 'DD/MM/YYYY', // 2019-02-01
            dmy_7: 'DD-MMMM-YYYY', // 24-October-2000
            dmy_8: 'DD MMMM YYYY', // 24 October 2000
            dmy_9: 'Y-M-D', // 2021-11-28 (backend-format)
            // Day
            d_1: 'dddd', //Sunday
            // Month
            m_1: 'MM', //01
            m_2: 'MMMM', //January
            // Year
            y_1: 'YYYY',
            // Hour
            time_1: 'HH A', // 21 PM
            time_2: 'HH:mm', // 21:20
            time_3: 'HH:mm A', // 21:20 PM
            time_4: 'HH:mm a', // 21:20 pm
            time_5: 'H:i:s', // 21:20:28 (backend-format)
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
    // dates
    formatToday (format) {
        return moment().format(format)
    },
    formatTommorow (format) {
        return moment().clone().add(1,'days').format(format)
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
    },
    isValidImageType (fileType) {
        return fileType.substring(fileType.indexOf("/")+1) == "png" || fileType.substring(fileType.indexOf("/")+1) == "jpg" || fileType.substring(fileType.indexOf("/")+1) == "jpeg"
    },
    isValidFilePDF(fileType){
        return fileType.substring(fileType.indexOf("/")+1) == "pdf"
    },
    // images
    checkForInsuranceLogo (url) {
        return !this.isDataEmpty(url) ? url : localURL + 'img/logo.png'
    },
    checkforBackgroundDetailWorkshopImage (a) {
        if(this.isObjectEmpty(a)){
            return localURL + 'storage/presetLogo/background_img_preset_detailWorkshop.jpeg'
        }
        return a[0].filePath
    },
    checkForProduction () {
        if(window.location.href.includes(vcpURL)) {
            return vcpURLBackend
        }
        return localURL
    }
}
