/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

export function getInsuranceStatusApi (userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(URL + '/api/getInsuranceStatusApi?userID='+ userID, authorization)
}

export function getVendorInsuranceList (userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(URL + '/api/getVendorInsuranceList', authorization)
}

export function getVendorInsuranceByID (id, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(URL + '/api/getVendorInsuranceByID?id=' + id, authorization)
}

export function getInsuranceDetailByStatusAccepted (userID, insuranceID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(URL + '/api/getInsuranceDetailByStatusAccepted?userID=' + userID + '&insuranceID=' + insuranceID, authorization)
}

export function getInsuranceDetailByStatusRejected (userID, insuranceID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(URL + '/api/getInsuranceDetailByStatusRejected?userID=' + userID + '&insuranceID=' + insuranceID, authorization)
}

export function makeInsuranceClaimApi (userID, vendorInsuranceID, insuranceForm, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/makeInsuranceClaimApi?userID=' + userID + '&vendorInsuranceID=' + vendorInsuranceID, insuranceForm, authorization)
}

export function makePathInsurance (imagePath, documentationInsuranceName, fileImage, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/makePathInsurance?imagePath=' + imagePath + '&documentationInsuranceName=' + documentationInsuranceName, fileImage, authorization)
}

export function updateInsurace (insuranceDocument, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/updateInsurace', insuranceDocument, authorization)
}
