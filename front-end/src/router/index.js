import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Vue from 'vue'
import verifiedAccount from "../views/verifiedAccount";
import Product from '../views/Product';
import Cart from '../views/Cart';
// Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  }, {
    path: '/verified-account',
    name: 'verifiedAccount',
    component: verifiedAccount,
    props: route => ({ page: parseInt(route.query.email) })
  },
  {
    path: '/login',
    name: 'login',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "login" */ '../views/Login.vue'),

  }, {
    path: '/pixel',
    name: 'pixel',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "pixel" */ '../views/Pixel.vue'),
  },
  {
    path: '/register',
    name: 'register',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "register" */ '../views/Register.vue'),
  }, {
    path: '/forget',
    name: 'forget',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "forget" */ '../views/Forget.vue'),
  }, {
    path: '/reset/:token',
    name: 'reset',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "reset" */ '../views/Reset.vue'),
  }, {
    path: '/activated/:link',
    name: 'activated',
    props: true,
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "reset" */ '../views/EmailActivated.vue'),
  }, {
    path: '/Profile',
    name: 'profile',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "reset" */ '../views/Profile.vue'),
  }, {
    path: '/verify-email',
    name: 'VerifyEmail',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "reset" */ '../views/VerifyEmail.vue'),
  }, {
    path: '/email/verify/success',
    name: 'Email-success',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].helpers) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "reset" */ '../views/EmailSuccess.vue'),
  }, , {
    path: '/product',
    name: 'product',
    component: Product,
  }, {
    path: '/Cart',
    name: 'Cart',
    component: Cart,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
