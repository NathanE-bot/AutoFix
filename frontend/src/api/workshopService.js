/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

export function getAllWorkshop(userToken, id) {
  const authorization = { headers: { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/workshop/id=', id, authorization)
}