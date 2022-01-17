<template>
    <q-page>
        HALO
    </q-page>
</template>

<script>
/* eslint-disable */
import { getScheduleList } from '../../api/ScheduleService'
import { LocalStorage } from 'quasar'

export default {
    data(){
        return {
            user: [],
            scheduleList: []
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
        this.doGetScheduleList()
    },
    methods: {
        doGetScheduleList () {
            let _this = this
            _this.loader = true
            let token = LocalStorage.getItem('autoRepairUser').data.access_token
            getScheduleList(_this.user.id, token).then(response => {
                let tempScheduleList = []
                let tempScheduleDetails = []
                tempScheduleList = response.data.schedules
                tempScheduleDetails = response.data.serviceDetail
                tempScheduleList.forEach(el1 => {
                    let tempObject = {
                        serviceDetail: {
                            periodicSerivce: {},
                            generalServices: []
                        }
                    }
                    tempScheduleDetails.forEach(el2 => {
                        if(el2.scheduleID === el1.id){
                            if(el2.serviceType == 'service umum'){
                                tempObject.serviceDetail.generalServices.push(el2)
                            } else {
                                tempObject.serviceDetail.periodicSerivce = el2
                            }
                        }
                    })
                    tempObject = {...tempObject, ...el1}
                    _this.scheduleList.push(tempObject)
               })
               console.log(_this.scheduleList)
            })
        }
    }
}
</script>