import Vue from 'vue';
import VueRouter from 'vue-router';
import { Home, Card, MyCard, LoginPage, CardItem, Register } from '../components/index.js';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Home,
  },
  {
    path: '/card',
    component: Card,
  },
  {
    path: '/mycard',
    component: MyCard,
  },
  {
    path: '/login',
    component: LoginPage,
  },
  {
    path: '/register',
    component: Register,
  },
  {
    path: '/card/:code',
    component: CardItem,
  },
];

const router = new VueRouter({
  mode: 'history',
  routes: routes,
});

export default router;
