/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

export function getIncomingClaimRequest(adminID) {
  return axios.get(URL + '/api/getDataIncomingInsuranceRequestByAdminID?adminID=' + adminID)
}

export function getAdminInsuranceDetails(insuranceID) {
  return axios.get(URL + '/api/getAdminInsuranceDetails?insuranceID=' + insuranceID)
}

export function rejectInsuranceClaim(insuranceID, insuranceDescription){
  return axios.post(URL + '/api/rejectInsuranceClaim?insuranceID=' + insuranceID + '&insuranceDescription=' + insuranceDescription)
}

export function acceptInsuranceClaim(insuranceID) {
  return axios.post(URL + '/api/acceptInsuranceClaim?insuranceID=' + insuranceID)
}

export function uploadPDFInsurance(insuranceID, filePDF){
  return axios.post(URL + '/api/uploadPDFInsurance?insuranceID=' + insuranceID, filePDF)
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

