/* eslint-disable */
import axios from 'axios'
var localURL = 'http://127.0.0.1:8000'

export default
  function kosong() {
  return true
}

export function getIncomingOrderSchedule(adminID) {
    return axios.get(localURL + '/api/getScheduleByWorkshopIDAndAdminWorkshop?adminID=' + adminID)
  }