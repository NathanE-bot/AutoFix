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

export function getWorkshopDetailByUserID(adminID) {
  return axios.get(localURL + '/api/getWorkshopDetailByUserID?adminID=' + adminID)
}

export function getScheduleAcceptedByAdmin(adminID) {
  return axios.get(localURL + '/api/getScheduleAcceptedByAdmin?adminID=' + adminID)
}

export function doDoneScheduleByAdmin(scheduleID) {
  return axios.post(localURL + '/api/doneScheduleByAdmin?scheduleID=' + scheduleID)
}

export function doCancelScheduleByAdmin(dataCancel) {
  return axios.post(localURL + '/api/cancelScheduleByAdmin', dataCancel)
}

export function doUpdateWorkshopForAdminBengkel(dataUpdate, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/updateWorkshopForAdminBengkel', dataUpdate, authorization)
}

export function addNewWorkshopDetail(workshopID, workshopDetail, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/addNewWorkshopDetail?workshopID=' + workshopID, workshopDetail, authorization)
}

export function deleteCarType(workshopID, id, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/deleteCarType?workshopID=' + workshopID + '&id=' + id, authorization)
}

export function deleteCarModel(workshopID, carModel, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/deleteCarModel?workshopID=' + workshopID + '&carModel=' + carModel, authorization)
}

export function addWorkshopService(carServices, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/addWorkshopService', carServices, authorization)
}

export function deleteWorkshopServiceByID(workshopDetailID, id, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/deleteWorkshopServiceByID?workshopDetailID=' + workshopDetailID + '&id=' + id, authorization)
}
