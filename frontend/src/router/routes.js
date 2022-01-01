/* eslint-disable */
import MainLayout from "layouts/MainLayout";
import LoginRegisterLayout from "layouts/LoginRegisterLayout";
import MemberLayout from "layouts/MemberLayout";

// LandingPage
const landingPage = () => import("pages/LandingPage");

// LoginRegister
const login = () => import("pages/LoginRegister/Login");
const register = () => import("pages/LoginRegister/Register");
const forgotPassword = () => import("pages/LoginRegister/ForgotPassword");
const resetPassword = () => import("pages/LoginRegister/ResetPassword");
const otp = () => import("pages/LoginRegister/OTP");

// Nico
const createWorkshop = () => import("pages/CreateWorkshop");
const editPage = () => import("pages/EditPage");

// Testing
const testing = () => import("pages/Testing");

// Profile
const yourAccount = () => import("pages/Profile/YourAccount");

// Workshop
const workshop = () => import("pages/Workshop/WorkshopPage");
const workshopMakeSchedule = () => import("pages/Workshop/WorkshopMakeSchedule");
const WorkshopDetail = () => import("pages/Workshop/WorkshopDetailPage");

// Insurance
const claimInsurance = () => import("pages/Insurance/ClaimInsurance");
const formInsurance = () => import("pages/Insurance/FormClaimInsurance");
const statusInsurance = () => import("pages/Insurance/StatusInsurance");
//chat
const homeMessage = () => import("pages/Chats/HomeMessage");
const roomMessage = () => import("pages/Chats/RoomMessage");

const routes = [
  // forLoginRegis
  {
    path: '/session',
    component: LoginRegisterLayout,
    children: [
      {
        path: "/session/register",
        component: register,
        meta: {
          title: 'Register'
        }
      },
      {
        path: "/session/login",
        component: login,
        meta: {
          title: 'Login'
        }
      },
      {
        path: "/session/forgotpassword",
        component: forgotPassword,
        meta: {
          title: 'Forgot Password'
        }
      },
      {
        path: "/session/resetpassword/:id",
        component: resetPassword,
        meta: {
          title: 'Reset Password'
        }
      },
      {
        path: "/session/otp/:id",
        component: otp,
        meta: {
          title: 'OTP'
        }
      }
    ]
  },
  // ForUsers
  {
    path: '/member',
    component: MemberLayout,
    children: [
      // chat
      {
        path: "/member/homemessage",
        component: homeMessage,
        meta: {
          title: 'Chat Message',
          breadcrumb: 'Chat Message'
        }
      },
      {
        path: "/member/homemessage/roommessage/:id",
        component: roomMessage,
        meta: {
          title: 'Room Message',
          breadcrumb: 'Room Message'
        }
      },
      // Insurance
      {
        path: "/member/insurance/status-insurance",
        component: statusInsurance,
        meta: {
          title: 'Status Insurance',
          breadcrumb: 'Status Insurance'
        }
      },
      {
        path: "/member/insurance/form",
        component: formInsurance,
        meta: {
          title: 'Form Insurance',
          breadcrumb: 'Form Insurance'
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
  // For not authenticated
  {
    path: "/",
    component: MainLayout,
    children: [
      // exception
      {
        path: "/insurance",
        component: claimInsurance,
        meta: {
          title: 'Claim Insurance',
          breadcrumb: 'Claim Insurance'
        }
      },
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
