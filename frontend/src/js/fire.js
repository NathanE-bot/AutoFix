/* eslint-disable */
// Import the functions you need from the SDKs you need
// import { initializeApp } from "firebase/app";
import firebase from "firebase/compat/app";
import "firebase/firestore";
import 'firebase/auth';
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBZtL6ewabJKvaHta40IlZK1q7fomwtkSg",
  authDomain: "autofix-1a7af.firebaseapp.com",
  projectId: "autofix-1a7af",
  storageBucket: "autofix-1a7af.appspot.com",
  messagingSenderId: "221535731065",
  appId: "1:221535731065:web:6a962792155e284a0e03a8"
};
var fire = firebase.initializeApp(firebaseConfig);
export default fire;
// Initialize Firebase
// const app = initializeApp(firebaseConfig)
