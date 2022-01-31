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

export function rejectInsuranceClaim(insuranceID, insuranceDescription){
  return axios.post(localURL + '/api/rejectInsuranceClaim?insuranceID=' + insuranceID + '&insuranceDescription=' + insuranceDescription)
}

export function acceptInsuranceClaim(insuranceID) {
  return axios.post(localURL + '/api/acceptInsuranceClaim?insuranceID=' + insuranceID)
}

export function uploadPDFInsurance(insuranceID, filePDF){
  return axios.post(localURL + '/api/uploadPDFInsurance?insuranceID=' + insuranceID, filePDF)
}