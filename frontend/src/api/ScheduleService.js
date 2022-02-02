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

export function makeSchedule(formSchedule, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/makeScheduleApi', formSchedule, authorization)
}

export function getScheduleList(userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getScheduleByUserID?userID=' + userID, authorization)
}

export function getHistoryScheduleList(userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(localURL + '/api/getHistoryByScheduleStatusAndUserID?userID=' + userID, authorization)
}

export function reviewSchedule(formReview, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(localURL + '/api/formReviewAPI', formReview, authorization)
}
