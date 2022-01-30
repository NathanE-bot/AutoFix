/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

export function getIncomingClaimRequest(adminID) {
  return axios.get(localURL + '/api/getDataIncomingInsuranceRequestByAdminID?adminID=' + adminID)
}

export function getAdminInsuranceDetails(insuranceID) {
  return axios.get(localURL + '/api/getAdminInsuranceDetails?insuranceID=' + insuranceID)
}