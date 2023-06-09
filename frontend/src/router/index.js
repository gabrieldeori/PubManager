import { createRouter, createWebHistory } from 'vue-router';
import Guard from '../middlewares/authorization';

const routes = [
  {
    path: '/client/register',
    name: 'ClientRegister',
    component: () => import('../views/ClientRegister.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/clients/show',
    name: 'ClientsShow',
    component: () => import('../views/ClientsShow.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/client/:id',
    name: 'ClientEdit',
    component: () => import('../views/ClientEdit.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/user/register',
    name: 'UserRegister',
    component: () => import('../views/UserRegister.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/users/show',
    name: 'UsersShow',
    component: () => import('../views/UsersShow.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/user/:id',
    name: 'UserEdit',
    component: () => import('../views/UserEdit.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/UserLogin.vue'),
    beforeEnter: Guard.loginAuth,
  },
  {
    path: '/logout',
    name: 'Logout',
    component: () => import('../views/UserLogout.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/products/show',
    name: 'ProductsShow',
    component: () => import('../views/ProductsShow.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/product/register',
    name: 'ProductsRegister',
    component: () => import('../views/ProductRegister.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/product/:id',
    name: 'ProductsEdit',
    component: () => import('../views/ProductEdit.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/purchases/show',
    name: 'PurchasesShow',
    component: () => import('../views/PurchasesShow.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/purchase/register',
    name: 'PurchaseRegister',
    component: () => import('../views/PurchaseRegister.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/purchase/:id',
    name: 'PurchaseEdit',
    component: () => import('../views/PurchaseEdit.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/comanda/register',
    name: 'ComandaRegister',
    component: () => import('../views/ComandaRegister.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/comandas/show',
    name: 'ComandasShow',
    component: () => import('../views/ComandasShow.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/comanda/:id',
    name: 'ComandaEdit',
    component: () => import('../views/ComandaEdit.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/cashregisters/show',
    name: 'CashRegistersShow',
    component: () => import('../views/CashRegistersShow.vue'),
    beforeEnter: Guard.auth,
  },
  {
    path: '/dashboard',
    name: 'DashBoard',
    component: () => import('../views/DashBoard.vue'),
    beforeEnter: Guard.auth,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL || '/'),
  routes,
});

export default router;
