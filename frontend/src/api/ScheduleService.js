/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

export function makeSchedule(formSchedule, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/makeScheduleApi', formSchedule, authorization)
}

export function getScheduleList(userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getScheduleByUserID?userID=' + userID, authorization)
}