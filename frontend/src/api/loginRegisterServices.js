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

export function loginToWebsite(userCredentials) {
  return axios.post(localURL + '/api/login', userCredentials)
}

export function registerToWebsite(userCredentials) {
  return axios.post(localURL + '/api/register', userCredentials)
}

export function requestForgotPasswordEmail(email) {
  return axios.post(localURL + '/api/doSendLinkForgotPassword', email)
}

export function resetUserPassword(formResetPassword) {
  return axios.post(localURL + '/api/doResetUserPassword', formResetPassword)
}

export function getTempUserID (id) {
  return axios.get(localURL + '/api/tempUserID?id=' + id)
}

export function verififcationEmailWithOtp (otp, encryptUserId) {
  return axios.post(localURL + '/api/doVerififcationEmailWithOtp?otp=' + otp + '&encryptUserId=' + encryptUserId)
}

export function resendOtp (email, encryptUserId) {
  return axios.post(localURL + '/api/doResendOtp?email=' + email + '&encryptUserId=' + encryptUserId)
}
