/* eslint-disable */
/*
export function someAction (context) {
}
*/
// Workshop
import { getAllWorkshop } from 'src/api/workshopService'
import { LocalStorage } from 'quasar'

export function fetchWorkshop (context) {
    context.commit('setLoadingStatusWorkshop', true)
    getAllWorkshop(LocalStorage.getKey(access_token)).then(response => {
        context.commit('setLoadingStatusWorkshop', false)
        context.commit('setDataWorkshop', response.data.objectReturn)
        console.log('workshop', response.data.objectReturn)
    }) .catch((err) =>{
        console.log(err)
    })
}