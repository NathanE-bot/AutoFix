/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

export function loginToWebsite(userCredentials) {
  return axios.post(localURL + '/api/login', userCredentials)
}
export function registerToWebsite(userCredentials) {
  return axios.post(localURL + '/api/register', userCredentials)
}