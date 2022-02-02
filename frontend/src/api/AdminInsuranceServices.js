/* eslint-disable */
import axios from 'axios'
var localURL = ''
if(window.location.href.includes('http://34.101.220.96/')){
  localURL = 'http://34.101.220.96:8080'
} else {
  localURL = 'http://127.0.0.1:8000'
}

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

export function getInsuranceHistory(adminID) {
  return axios.get(localURL + '/api/getInsuranceHistory?adminID=' + adminID)
}

export function getChartCountDataTotalClaimedInsurance (adminID, month, year) {
  return axios.get(localURL + '/api/countDataTotalClaimedInsurance?adminID=' + adminID + '&month=' + month + '&year=' + year)
}

export function getYearInsuranceForFilterHome(){
  return axios.get(localURL + '/api/getYearInsuranceForFilterHome' )
}

export function getCountDataTotalClaimedInsuranceByStatus(adminID, year){
  return axios.get(localURL + '/api/countDataTotalClaimedInsuranceByStatus?adminID=' + adminID + '&year=' + year)
}