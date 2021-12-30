/* eslint-disable */
import firebase from 'firebase/app/dist'
import { firebaseConfig } from './js/firebase-config'
import { initializeApp } from "firebase/app";
import { getFirestore } from "firebase/firestore";
import { getAuth } from "firebase/auth";
import "firebase/firestore"

export const app = initializeApp(firebaseConfig)
export const auth = getAuth()
export const db = getFirestore()
export const test = firebase.firestore()

// db.collection('Messages').get().then(r => {
//     r.docs.map(doc => {
//         console.log(doc.data())
//     })
// })

console.log(test)