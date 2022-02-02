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

// export function getAllWorkshop(userToken) {
//   const authorization = { headers: { 'Authorization': 'Bearer ' + userToken } }
//   return axios.get(localURL + '/api/workshop', authorization)
// }

export function getRecommendWorkshop(lat, lon) {
  return axios.get(localURL + '/api/getRecommendationWorkshop?lat=' + lat + '&lon=' + lon)
}

export function getAllWorkshops() {
  return axios.get(localURL + '/api/getAllWorkshop')
}

export function getWorkshopApi(jsonDataParam) {
  return axios.post(localURL + '/api/getWorkshopApi', jsonDataParam)
}

export function getWorkshopById(id) {
  return axios.get(localURL + '/api/getWorkshopById?id=' + id)
}

export function countDistanceFromCurrPos(currPos) {
  return axios.post(localURL + '/api/doCountDistanceFromCurrPos', currPos)
}

export function getUserWorkshopByWorkshopId(userID){
  return axios.post(localURL + '/api/getUserWorkshopByWorkshopId?userID=' + userID)
}
