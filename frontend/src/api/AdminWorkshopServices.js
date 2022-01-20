/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

export function getIncomingOrderSchedule(adminID) {
  return axios.get(localURL + '/api/getScheduleByWorkshopIDAndAdminWorkshop?adminID=' + adminID)
}

export function doAcceptScheduleByAdmin(scheduleID) {
  return axios.post(localURL + '/api/acceptScheduleByAdmin?scheduleID=' + scheduleID)
}

export function doRejectScheduleByAdmin(dataReject) {
  return axios.post(localURL + '/api/rejectedScheduleByAdmin', dataReject)
}

export function getScheduleAcceptedByAdmin(adminID) {
  return axios.get(localURL + '/api/getScheduleAcceptedByAdmin?adminID=' + adminID)
}

export function doDoneScheduleByAdmin(scheduleID) {
  return axios.post(localURL + '/api/doneScheduleByAdmin?scheduleID' + scheduleID)
}

export function doCancelScheduleByAdmin(dataCancel) {
  return axios.post(localURL + '/api/cancelScheduleByAdmin', dataCancel)
}