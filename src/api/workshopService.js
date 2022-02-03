/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

// export function getAllWorkshop(userToken) {
//   const authorization = { headers: { 'Authorization': 'Bearer ' + userToken } }
//   return axios.get(localURL + '/api/workshop', authorization)
// }

export function getRecommendWorkshop(lat, lon) {
  return axios.get(URL + '/api/getRecommendationWorkshop?lat=' + lat + '&lon=' + lon)
}

export function getAllWorkshops() {
  return axios.get(URL + '/api/getAllWorkshop')
}

export function getWorkshopApi(jsonDataParam) {
  return axios.post(URL + '/api/getWorkshopApi', jsonDataParam)
}

export function getWorkshopById(id) {
  return axios.get(URL + '/api/getWorkshopById?id=' + id)
}

export function countDistanceFromCurrPos(currPos) {
  return axios.post(localURL + '/api/doCountDistanceFromCurrPos', currPos)
}

export function getUserWorkshopByWorkshopId(userID){
  return axios.post(localURL + '/api/getUserWorkshopByWorkshopId?userID=' + userID)
}
