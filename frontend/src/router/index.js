import { createRouter, createWebHistory } from 'vue-router';
import Guard from '../middlewares/authorization';

const routes = [
  {
    path: '/',
    name: 'components',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/Components.vue'),
  },
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
    path: '/products/show',
    name: 'ProductsShow',
    component: () => import('../views/ProductsShow.vue'),
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
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
