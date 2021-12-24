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

// Workshop
const workshop = () => import("pages/Workshop/WorkshopPage");
const workshopMakeSchedule = () => import("pages/Workshop/WorkshopMakeSchedule");
const WorkshopDetail = () => import("pages/Workshop/WorkshopDetailPage");

// Insurance
const homeInsurance = () => import("pages/Insurance/HomeInsurance")

const routes = [
  // forLoginRegis
  {
    path: '/session',
    component: LoginRegisterLayout,
    children: [
      {
        path: "/session/login",
        component: login,
        meta: {
          title: 'Login'
        }
      },
      {
        path: "/session/register",
        component: register,
        meta: {
          title: 'Register'
        }
      }
    ]
  },
  // ForUsers
  {
    path: '/member',
    component: MemberLayout,
    children: [
      // Insurance
      {
        path: "/member/insurance",
        component: homeInsurance,
        meta: {
          title: 'Home Insurance',
          breadcrumb: 'Home Insurance'
        }
      },
      {
        path: "/member/create",
        component: createWorkshop,
        meta: {
          title: '',
          breadcrumb: ''
        }
      },
      {
        path: "/member/edit",
        component: editPage,
        meta: {
          title: '',
          breadcrumb: ''
        }
      },
      {
        path: "/member/youraccount",
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
      {
        path: "/testing",
        component: testing,
        meta: {
          title: 'Testing',
          breadcrumb: 'Testing'
        }
      },
      {
        path: "/workshop",
        component: workshop,
        meta: {
          title: 'Workshop Page',
          breadcrumb: 'Workshop Page'
        }
      },
      {
        path: "/workshop/detail",
        component: WorkshopDetail,
        meta: {
          title: 'Workshop Detail Page',
          breadcrumb: 'Workshop Detail Page'
        }
      },
      {
        path: "/workshop/make-schedule",
        component: workshopMakeSchedule,
        meta: {
          title: 'Workshop Page',
          breadcrumb: 'Workshop Page'
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
