/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

export function getIncomingOrderSchedule(adminID) {
  return axios.get(URL + '/api/getScheduleByWorkshopIDAndAdminWorkshop?adminID=' + adminID)
}

export function doAcceptScheduleByAdmin(scheduleID) {
  return axios.post(URL + '/api/acceptScheduleByAdmin?scheduleID=' + scheduleID)
}

export function doRejectScheduleByAdmin(dataReject) {
  return axios.post(URL + '/api/rejectedScheduleByAdmin', dataReject)
}

export function getWorkshopDetailByUserID(adminID) {
  return axios.get(URL + '/api/getWorkshopDetailByUserID?adminID=' + adminID)
}

export function getScheduleAcceptedByAdmin(adminID) {
  return axios.get(URL + '/api/getScheduleAcceptedByAdmin?adminID=' + adminID)
}

export function doDoneScheduleByAdmin(scheduleID) {
  return axios.post(URL + '/api/doneScheduleByAdmin?scheduleID=' + scheduleID)
}

export function doCancelScheduleByAdmin(dataCancel) {
  return axios.post(URL + '/api/cancelScheduleByAdmin', dataCancel)
}

export function doUpdateWorkshopForAdminBengkel(dataUpdate, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/updateWorkshopForAdminBengkel', dataUpdate, authorization)
}

export function addNewWorkshopDetail(workshopID, workshopDetail, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/addNewWorkshopDetail?workshopID=' + workshopID, workshopDetail, authorization)
}

export function deleteCarType(workshopID, id, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/deleteCarType?workshopID=' + workshopID + '&id=' + id, authorization)
}

export function deleteCarModel(workshopID, carModel, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/deleteCarModel?workshopID=' + workshopID + '&carModel=' + carModel, authorization)
}

export function addWorkshopService(carServices, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/addWorkshopService', carServices, authorization)
}

export function deleteWorkshopServiceByID(workshopDetailID, id, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/deleteWorkshopServiceByID?workshopDetailID=' + workshopDetailID + '&id=' + id, authorization)
}

export function deleteWorkshopServiceByStatusAndID(workshopDetailID, serviceType, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/deleteWorkshopServiceByStatusAndID?workshopDetailID=' + workshopDetailID + '&serviceType=' + serviceType, authorization)
}

export function updateLogoWorkshop(workshopID, workshopLogo, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/updateLogoWorkshop?workshopID=' + workshopID, workshopLogo, authorization)
}

export function makeGaleryWorkshopPath(workshopID, workshopPictureID, workshopPicture, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/makeGaleryWorkshopPath?workshopID=' + workshopID + '&workshopPictureID=' + workshopPictureID, workshopPicture, authorization)
}

// export function updateGaleryWorkshop(workshopID, workshopPictureID, workshopPicture, userToken) {
//   const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
//   return axios.post(URL + '/api/updateGaleryWorkshop?workshopID=' + workshopID + '&workshopPictureID=' + workshopPictureID, workshopPicture, authorization)
// }

export function getYearWorkshopForFilterHome(){
  return axios.get(URL + '/api/getYearWorkshopForFilterHome' )
}

export function getSumAllPriceEstimationWorkshop(adminID, month, year){
  return axios.get(URL + '/api/SumAllPriceEstimationWorkshop?adminID=' + adminID + '&month=' + month + '&year=' + year)
}

export function getCountAllDataWorkshop (adminID, month, year) {
  return axios.get(URL + '/api/countAllDataWorkshop?adminID=' + adminID + '&month=' + month + '&year=' + year)
}

export function getCountWorkshopByStatus(adminID, month, year){
  return axios.get(URL + '/api/countWorkshopByStatus?adminID=' + adminID + '&month=' + month + '&year=' + year)
}

export function getScheduleHistoryByAdmin(adminID){
  return axios.get(URL + '/api/getScheduleHistoryByAdmin?adminID=' + adminID)
}
