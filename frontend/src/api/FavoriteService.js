/* eslint-disable */
import axios from 'axios'
var localURL = ''
if(window.location.href.includes('http://34.126.189.122/')){
  localURL = 'http://34.101.220.96:8080'
} else {
  localURL = 'http://127.0.0.1:8000'
}

export default
  function kosong() {
  return true
}

export function addFavoriteToUser (userID, workshopID, userToken) {
    const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
    return axios.post(localURL + '/api/makeFavoritesByWorkshopAndUserID?userID='+ userID + '&workshopID=' + workshopID, authorization)
}

export function getFavoritesByUserID (userID, userToken) {
    const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
    return axios.get(localURL + '/api/getFavoritesByUserID?userID='+ userID, authorization)
}

export function removeFavoriteFromUser (userID, workshopID, userToken) {
    const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
    return axios.post(localURL + '/api/deletFavoritesData?userID='+ userID + '&workshopID=' + workshopID, authorization)
}
