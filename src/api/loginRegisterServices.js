/* eslint-disable */
import axios from 'axios'
import help from '../js/help'
var URL = help.checkForProduction()

export default
  function kosong() {
  return true
}

export function loginToWebsite(userCredentials) {
  return axios.post(URL + '/api/login', userCredentials)
}

export function registerToWebsite(userCredentials) {
  return axios.post(URL + '/api/register', userCredentials)
}

export function requestForgotPasswordEmail(email) {
  return axios.post(URL + '/api/doSendLinkForgotPassword', email)
}

export function resetUserPassword(formResetPassword) {
  return axios.post(URL + '/api/doResetUserPassword', formResetPassword)
}

export function getTempUserID (id) {
  return axios.get(URL + '/api/tempUserID?id=' + id)
}

export function verififcationEmailWithOtp (otp, encryptUserId) {
  return axios.post(localURL + '/api/doVerififcationEmailWithOtp?otp=' + otp + '&encryptUserId=' + encryptUserId)
}

export function resendOtp (email, encryptUserId) {
  return axios.post(localURL + '/api/doResendOtp?email=' + email + '&encryptUserId=' + encryptUserId)
}
