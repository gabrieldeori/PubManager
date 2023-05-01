import { createRouter, createWebHistory } from 'vue-router';

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
  },
  {
    path: '/clients/show',
    name: 'ClientsShow',
    component: () => import('../views/ClientsShow.vue'),
  },
  {
    path: '/client/:id',
    name: 'ClientEdit',
    component: () => import('../views/ClientEdit.vue'),
  },
  {
    path: '/user/register',
    name: 'UserRegister',
    component: () => import('../views/UserRegister.vue'),
  },
  {
    path: '/users/show',
    name: 'UsersShow',
    component: () => import('../views/UsersShow.vue'),
  },
  {
    path: '/user/:id',
    name: 'UserEdit',
    component: () => import('../views/UserEdit.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
