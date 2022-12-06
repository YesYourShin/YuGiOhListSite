import Vue from 'vue';
import VueRouter from 'vue-router';
import { Home, Card, MyCard, LoginPage, CardItem, Register } from '../components/index.js';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Home,
  },
  // {
  //   path: '/card',
  //   component: Card,
  // },
  {
    path: '/card',
    name: 'CardList',
    component: Card,
    beforeEnter: ({ name, query }, from, next) => {
      if (name === 'CardList' && !('page' in query)) {
        query.page = 1;
      }
      // next()를 해줘야 페이지 이동이 됨
      next();
      console.log(from);
    },
  },
  {
    path: '/mycard',
    name: 'MyCard',
    component: MyCard,
    beforeEnter: ({ name, query }, from, next) => {
      if (name === 'MyCard' && !('page' in query)) {
        query.page = 1;
      }
      // next()를 해줘야 페이지 이동이 됨
      next();
      console.log(from);
    },
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
