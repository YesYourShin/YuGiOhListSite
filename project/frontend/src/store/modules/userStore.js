import router from '../../router/index.js';
import axios from 'axios';

const userStore = {
  state: {
    myInfo: {
      email: '',
      nickname: '',
    },
    token: '',
    lang: 'ko',
    cards: [],
  },
  mutations: {
    login(state, payload) {
      state.token = payload.token;
      // router.push({ path: '/card' });
    },
    getMyInfo(state, payload) {
      if (!state.token) {
        router
          .push({
            path: 'login',
          })
          .catch(error => {
            console.log(error);
          });
      }
      // this.$store.commit('isNotLogin');
      state.myInfo.email = payload.myInfo.email;
      state.myInfo.name = payload.myInfo.name;
    },
    logout(state) {
      // 서버에 요청해서 로그아웃 하기
      state.token = '';
      // console.log(router.path)
      // router.push({ path: '/' });
    },
    updateLang(state, lang) {
      // console.log('lang', lang);
      state.cards = [];
      state.lang = lang;
    },
    getCards(state, page) {
      axios
        .get(`/api/card/${state.lang}/index?page=${page}`)
        .then(response => {
          response.data.data.forEach(card => {
            state.cards.push(card);
          });
        })
        .catch(function (error) {
          console.error(error);
        });
    },
    getMyCards(state, page) {
      axios
        .get(`/api/card/${state.lang}/usercardindex?page=${page}`, {
          headers: {
            'Content-Type': `application/json`,
            Authorization: 'Bearer ' + state.token,
          },
        })
        .then(response => {
          response.data.data.forEach(card => {
            state.cards.push(card);
          });
        })
        .catch(function (error) {
          console.error(error);
        });
    },
  },
  getters: {
    isLogin(state) {
      // 로그인이 되어 있으면 true
      if (state.token) {
        return true;
      }
      // 로그인이 안 되어 있으면 false
      return false;
    },
    getToken(state) {
      return state.token;
    },
    getLang(state) {
      return state.lang;
    },
    getCards(state) {
      return state.cards;
    },
  },
  actions: {},
};

export default userStore;
