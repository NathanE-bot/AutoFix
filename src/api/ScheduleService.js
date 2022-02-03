/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

export function makeSchedule(formSchedule, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/makeScheduleApi', formSchedule, authorization)
}

export function getScheduleList(userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(URL + '/api/getScheduleByUserID?userID=' + userID, authorization)
}

export function getHistoryScheduleList(userID, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.get(URL + '/api/getHistoryByScheduleStatusAndUserID?userID=' + userID, authorization)
}

export function reviewSchedule(formReview, userToken) {
  const authorization = { 'headers': { 'Authorization': 'Bearer ' + userToken } }
  return axios.post(URL + '/api/formReviewAPI', formReview, authorization)
}
