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

export function getWorkshopApi(iPage, workshopName, location, statusHr, status24Hr) {
  return axios.post(localURL + '/api/getWorkshopApi?page=' + iPage + '&workshopName=' + workshopName + '&location=' + location + '&statusHr=' + statusHr + '&status24Hr=' + status24Hr)
}

export function getWorkshopById(id) {
  return axios.get(localURL + '/api/getWorkshopById?id=' + id)
}

export function countDistanceFromCurrPos(currPos) {
  return axios.post(localURL + '/api/doCountDistanceFromCurrPos', currPos)
}