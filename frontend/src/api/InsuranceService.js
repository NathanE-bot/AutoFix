/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

export function getInsuranceStatusApi (userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getInsuranceStatusApi?userID='+ userID, authorization)
}

export function getVendorInsuranceList (userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getVendorInsuranceList', authorization)
}

export function getVendorInsuranceByID (id, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getVendorInsuranceByID?id=' + id, authorization)
}

export function getInsuranceDetailByStatusAccepted (userID, insuranceID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getInsuranceDetailByStatusAccepted?userID=' + userID + '&insuranceID=' + insuranceID, authorization)
}

export function getInsuranceDetailByStatusRejected (userID, insuranceID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getInsuranceDetailByStatusRejected?userID=' + userID + '&insuranceID=' + insuranceID, authorization)
}
