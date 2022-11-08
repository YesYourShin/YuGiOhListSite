import Vue from 'vue';
import VueRouter from 'vue-router';
import { Home, Card, MyCard, Login, CardItem } from './components/index.js';

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
    component: Login,
  },
  {
    path: '/card/:id',
    component: CardItem,
  },
];

const router = new VueRouter({
  mode: 'history',
  routes: routes,
});

export default router;
