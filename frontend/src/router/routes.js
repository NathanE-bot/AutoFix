/* eslint-disable */
import MainLayout from "layouts/MainLayout";
import LoginRegisterLayout from "layouts/LoginRegisterLayout";
import MemberLayout from "layouts/MemberLayout";
import AdminWorkshopLayout from "layouts/AdminWorkshopLayout";
import AdminInsuranceLayout from "layouts/AdminInsuranceLayout";

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
const scheduleList = () => import("pages/Profile/ScheduleList");
const historyList = () => import("pages/Profile/HistoryList");
const favoriteList = () => import("pages/Profile/FavoriteList");
//chat
const homeMessage = () => import("pages/Chats/HomeMessage");
// const roomMessage = () => import("pages/Chats/RoomMessage");

// Workshop
const workshop = () => import("pages/Workshop/WorkshopPage");
const workshopMakeSchedule = () => import("pages/Workshop/WorkshopMakeSchedule");
const WorkshopDetail = () => import("pages/Workshop/WorkshopDetailPage");

// Insurance
const claimInsurance = () => import("pages/Insurance/ClaimInsurance");
const formInsurance = () => import("pages/Insurance/FormClaimInsurance");
const statusInsurance = () => import("pages/Insurance/StatusInsurance");
const statusInsuranceDetail = () => import("pages/Insurance/StatusInsuranceDetail");

//Admin Workshop
const AdminWorkshopHome = () => import("pages/Admin/AdminWorkshop/AdminWorkshopHome");
const AdminAcceptedOrder = () => import("pages/Admin/AdminWorkshop/AcceptedOrder");
const AdminIncomingOrder = () => import("pages/Admin/AdminWorkshop/IncomingOrder");
const AdminManageWorkshop = () => import("pages/Admin/AdminWorkshop/ManageWorkshop");
const AdminWorkshopChatRoom = () => import("pages/Admin/AdminWorkshop/AdminWorkshopChatPage");
const AdminHistoryOrder = () => import("pages/Admin/AdminWorkshop/HistoryOrder");

//Admin Insurance
const AdminInsuranceHome = () => import("pages/Admin/AdminInsurance/AdminInsuranceHome");
const AdminIncomingClaimRequest = () => import("pages/Admin/AdminInsurance/IncomingClaimRequest");
const AdminIncomingClaimRequestDetail = () => import("pages/Admin/AdminInsurance/IncomingClaimRequestDetail")
const AdminInsuranceClaimHistory = () => import("pages/Admin/AdminInsurance/InsuranceClaimHistory");

// const insuranceAdmin = () => import("pages/Admin/AdminInsurance");

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
  // ForAdminWorkshopUsers
  {
    path: '/admin/workshop',
    component: AdminWorkshopLayout,
    children: [
      {
        path: "/admin/workshop/chat-room",
        component: AdminWorkshopChatRoom,
        meta: {
          title: 'Manage Workshop',
          breadcrumb: 'Manage Workshop'
        }
      },
      {
        path: "/admin/workshop/manage-workshop",
        component: AdminManageWorkshop,
        meta: {
          title: 'Manage Workshop',
          breadcrumb: 'Manage Workshop'
        }
      },
      {
        path: "/admin/workshop/accepted-order",
        component: AdminAcceptedOrder,
        meta: {
          title: 'Accepted Order Admin',
          breadcrumb: 'Accepted Order Admin'
        }
      },
      {
        path: "/admin/workshop/incoming-order",
        component: AdminIncomingOrder,
        meta: {
          title: 'Incoming Order Admin',
          breadcrumb: 'Incoming Order Admin'
        }
      },
      {
        path: "/admin/workshop/home",
        component: AdminWorkshopHome,
        meta: {
          title: 'Admin Workshop Home',
          breadcrumb: 'Admin Workshop Home'
        }
      },
      {
        path: "/admin/workshop/history-order",
        component: AdminHistoryOrder,
        meta: {
          title: 'History Order Admin',
          breadcrumb: 'History Order Admin'
        }
      }
    ]
  },
  // ForAdminInsuranceUsers
  {
    path: '/admin/insurance',
    component: AdminInsuranceLayout,
    children: [
      {
        path: "/admin/insurance/home",
        component: AdminInsuranceHome,
        meta: {
          title: 'Admin Insurance Home',
          breadcrumb: 'Admin Insurance Home'
        }
      },
      {
        path: "/admin/insurance/incoming-claim-request",
        component: AdminIncomingClaimRequest,
        meta: {
          title: 'Incoming Claim Request',
          breadcrumb: 'Incoming Claim Request'
        }
      },
      {
        path: "/admin/insurance/incoming-claim-request/detail/:insuranceID",
        component: AdminIncomingClaimRequestDetail,
        meta: {
          title: 'Incoming Claim Request Detail',
          breadcrumb: 'Incoming Claim Request Detail'
        }
      },
      {
        path: "/admin/insurance/insurance-claim-history",
        component: AdminInsuranceClaimHistory,
        meta: {
          title: 'Insurance Claim History',
          breadcrumb: 'Insurance Claim History'
        }
      },
      {
        path: "/admin/insurance/insurance-claim-history/detail/:insuranceID",
        component: AdminIncomingClaimRequestDetail,
        meta: {
          title: 'Insurance Claim History',
          breadcrumb: 'Insurance Claim History'
        }
      }
    ]
  },
  // ForUsers
  {
    path: '/member',
    component: MemberLayout,
    children: [
      {
        path: "/member/favorite-list",
        component: favoriteList,
        meta: {
          title: 'Favorite List',
          breadcrumb: 'Favorite List'
        }
      },
      {
        path: "/member/history-list",
        component: historyList,
        meta: {
          title: 'History List',
          breadcrumb: 'History List'
        }
      },
      {
        path: "/member/schedule-list",
        component: scheduleList,
        meta: {
          title: 'Schedule List',
          breadcrumb: 'Schedule List'
        }
      },
      // chat
      {
        path: "/member/home-message",
        component: homeMessage,
        meta: {
          title: 'Chat Message',
          breadcrumb: 'Chat Message'
        }
      },
      // {
      //   path: "/member/home-message/room-message/:id",
      //   component: roomMessage,
      //   meta: {
      //     title: 'Room Message',
      //     breadcrumb: 'Room Message'
      //   }
      // },
      // Insurance
      {
        path: "/member/insurance/form/:id",
        component: formInsurance,
        meta: {
          title: 'Form Insurance',
          breadcrumb: 'Form Insurance'
        }
      },
      // workshop
      {
        path: "/member/workshop/make-schedule/:id",
        component: workshopMakeSchedule,
        meta: {
          title: 'Workshop Page',
          breadcrumb: 'Workshop Page'
        }
      },
      {
        path: "/member/your-account",
        component: yourAccount,
        meta: {
          title: 'Your Account',
          breadcrumb: 'Your Account'
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
    ]
  },
  // For not authenticated
  {
    path: "/",
    component: MainLayout,
    children: [
      // exception
      {
        path: "/insurance/claim-insurance",
        component: claimInsurance,
        meta: {
          title: 'Claim Insurance',
          breadcrumb: 'Claim Insurance'
        }
      },
      {
        path: "/insurance/status-insurance",
        component: statusInsurance,
        meta: {
          title: 'Status Insurance',
          breadcrumb: 'Status Insurance'
        }
      },
      {
        path: "/insurance/status-insurance/detail/:insuranceStatus/:insuranceID",
        component: statusInsuranceDetail,
        meta: {
          title: 'Status Insurance Detail',
          breadcrumb: 'Status Insurance Detail'
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
      // {
      //   path: "/testing",
      //   component: testing,
      //   meta: {
      //     title: 'Testing',
      //     breadcrumb: 'Testing'
      //   }
      // },
      {
        path: "/workshop",
        component: workshop,
        meta: {
          title: 'Workshop Page',
          breadcrumb: 'Workshop Page'
        }
      },
      {
        path: "/workshop/detail/:id",
        component: WorkshopDetail,
        meta: {
          title: 'Workshop Detail Page',
          breadcrumb: 'Workshop Detail Page'
        }
      }
    ]
  },
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
