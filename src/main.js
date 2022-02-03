/* eslint-disable */
// import firebase from 'firebase/app/dist'
// import { firebaseConfig } from './js/firebase-config'
// import { initializeApp } from "firebase/app";
// import { getFirestore } from "firebase/firestore";
// import { getAuth } from "firebase/auth";
import {firebaseConfig} from './js/firebase-config'
import "firebase/firestore"
import firebase from 'firebase/app'
import 'firebase/database'
// import 'firebase/auth';
import 'firebase/firestore'
var fire = firebase.initializeApp(firebaseConfig);
export default fire;

// export const auth = getAuth()
// export const db = getFirestore()
export const db = firebase.firestore()

// db.collection('Messages').get().then(r => {
//     r.docs.map(doc => {
//         console.log(doc.data())
//     })
// })
