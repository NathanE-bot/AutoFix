/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

export function addFavoriteToUser (userID, workshopID, userToken) {
    const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
    return axios.post(URL + '/api/makeFavoritesByWorkshopAndUserID?userID='+ userID + '&workshopID=' + workshopID, authorization)
}

export function getFavoritesByUserID (userID, userToken) {
    const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
    return axios.get(URL + '/api/getFavoritesByUserID?userID='+ userID, authorization)
}

export function removeFavoriteFromUser (userID, workshopID, userToken) {
    const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
    return axios.post(URL + '/api/deletFavoritesData?userID='+ userID + '&workshopID=' + workshopID, authorization)
}
