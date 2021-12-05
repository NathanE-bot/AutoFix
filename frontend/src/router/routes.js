/* eslint-disable */
import MainLayout from "layouts/MainLayout";

const index = () => import("pages/LandingPage");
const register = () => import("pages/LoginRegister/Register");
const login = () => import("pages/LoginRegister/Login");
const createWorkshop = () => import("pages/CreateWorkshop");
const editPage = () => import("pages/EditPage");
const error404 = () => import("pages/Error404");

const routes = [
  {
    path: "/",
    component: MainLayout,
    children: [
      {
        path: "/",
        component: index,
        meta: {
          title: 'Landing Page',
          breadcrumb: 'Landing Page'
        }
      },
      {
        path: "/login",
        component: login,
        meta: {
          title: 'Login',
          breadcrumb: 'Login'
        }
      },
      {
        path: "/register",
        component: register,
        meta: {
          title: 'Register',
          breadcrumb: 'Register'
        }
      },
      {
        path: "/create",
        component: createWorkshop,
        meta: {
          title: '',
          breadcrumb: ''
        }
      },
      {
        path: "/edit",
        component: editPage,
        meta: {
          title: '',
          breadcrumb: ''
        }
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
