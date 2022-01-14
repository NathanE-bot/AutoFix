/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

// Need Access Token
export function updateDataUserProfile(userCred) {
  return axios.post(localURL + '/api/updateDataUserProfile', userCred)
}
export function saveImgTest(fileImg, id){
  return axios.post(localURL + '/api/saveImg?id=' + id, fileImg)
}