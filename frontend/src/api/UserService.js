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

// Need Access Token
export function updateDataUserProfile(userCred, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/updateDataUserProfile', userCred, authorization)
}

export function saveImgTest(fileImg, id, userToken){
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/saveImg?id=' + id, fileImg, authorization)
}

export function deleteUserAccount(userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.delete(localURL + '/api/deleteUserAccount?userID=' + userID, authorization)
}