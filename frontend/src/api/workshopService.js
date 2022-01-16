/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

// export function getAllWorkshop(userToken) {
//   const authorization = { headers: { 'Authorization': 'Bearer ' + userToken } }
//   return axios.get(localURL + '/api/workshop', authorization)
// }

export function getRecommendWorkshop() {
  return axios.get(localURL + '/api/getRecommendationWorkshop')
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
