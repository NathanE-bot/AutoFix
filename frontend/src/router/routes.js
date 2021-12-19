/* eslint-disable */
import MainLayout from "layouts/MainLayout";
import LoginRegisterLayout from "layouts/LoginRegisterLayout";
import MemberLayout from "layouts/MemberLayout";

// LandingPage
const landingPage = () => import("pages/LandingPage");

// LoginRegister
const login = () => import("pages/LoginRegister/Login");
const register = () => import("pages/LoginRegister/Register");

// Nico
const createWorkshop = () => import("pages/CreateWorkshop");
const editPage = () => import("pages/EditPage");
// const error404 = () => import("pages/Error404");

// Testing
const testing = () => import("pages/Testing");

// Profile
const yourAccount = () => import("pages/Profile/YourAccount");

// WorkshopDetail
// const WorkshopDetail = () => import("pages/Workshop/WorkshopDetailPage");

const routes = [
  // forLoginRegis
  {
    path: '/session/',
    component: LoginRegisterLayout,
    children: [
      {
        path: "login",
        component: login,
        meta: {
          title: 'Login'
        }
      },
      {
        path: "register",
        component: register,
        meta: {
          title: 'Register'
        }
      }
    ]
  },
  // ForUsers
  {
    path: '/member/',
    component: MemberLayout,
    children: [
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
      {
        path: "/youraccount",
        component: yourAccount,
        meta: {
          title: 'Your Account',
          breadcrumb: 'Your Account'
        }
      }
    ]
  },
  {
    path: "/",
    component: MainLayout,
    children: [
      {
        path: "/",
        component: landingPage,
        meta: {
          title: 'Landing Page',
          breadcrumb: 'Landing Page'
        }
      },
      // {
      //   path: "/workshop/detail",
      //   component: WorkshopDetail,
      //   meta: {
      //     title: 'Workshop Detail Page',
      //     breadcrumb: 'Workshop Detail Page'
      //   }
      // },
      {
        path: "/testing",
        component: testing,
        meta: {
          title: 'Testing',
          breadcrumb: 'Testing'
        }
      }
    ]
  }
];

export default routes;

// Always leave this as last one
if (process.env.MODE !== "ssr") {
  routes.push({
    path: "/:catchAll(.*)*",
    component: () => import("pages/Error404.vue")
  });
}

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
