/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

// Need Access Token
export function updateDataUserProfile(userCred, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/updateDataUserProfile', userCred, authorization)
}

export function saveImgTest(fileImg, id, userToken){
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/saveImg?id=' + id, fileImg, authorization)
}

export function deleteUserAccount(userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.delete(URL + '/api/deleteUserAccount?userID=' + userID, authorization)
}
