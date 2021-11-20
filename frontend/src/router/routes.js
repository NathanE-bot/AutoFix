/* eslint-disable */
import MainLayout from "layouts/MainLayout";

const index = () => import("pages/Index");
const register = () => import("pages/Register");
const login = () => import("pages/Login");
const error404 = () => import("pages/Error404");

const routes = [
  {
    path: "/",
    component: MainLayout,
    children: [
      {
        path: "/",
        component: index
      },
      {
        path: "/login",
        component: login
      },
      {
        path: "/register",
        component: register
      },
      // Always leave this as last one
      {
        path: "/:catchAll(.*)*",
        component: error404
      }
    ]
  }
];

export default routes;

// Always leave this as last one
// if (process.env.MODE !== "ssr") {
//   routes.push({
//     path: "/:catchAll(.*)*",
//     component: () => import("pages/Error404.vue")
//   });
// }

// const routes = [
//   {
//     path: '/',
//     component: () => import('layouts/MainLayout.vue'),
//     children: [
//       { path: '', component: () => import('pages/Index.vue') }
//     ]
//   },
//   {
//     path: '/Login',
//     component: () => import('layouts/MainLayout.vue'),
//     children: [
//       { path: '', component: () => import('pages/Login.vue') }
//     ]
//   },
//   {
//     path: '/Register',
//     component: () => import('layouts/MainLayout.vue'),
//     children: [
//       { path: '', component: () => import('pages/Register.vue') }
//     ]
//   },
//   // Always leave this as last one,
//   // but you can also remove it
//   {
//     path: '/:catchAll(.*)*',
//     component: () => import('pages/Error404.vue')
//   }
// ]
