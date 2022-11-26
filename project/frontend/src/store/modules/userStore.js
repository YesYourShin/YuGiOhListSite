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
    card: [],
  },
  mutations: {
    login(state, payload) {
      state.token = payload.token;
    },
    getMyInfo(state, myInfo) {
      state.myInfo.email = myInfo.email;
      state.myInfo.name = myInfo.name;
      router.push({ path: '/card' });
    },
    logout(state) {
      // 서버에 요청해서 로그아웃 하기
      state.token = '';
      // console.log(router.path)
      // router.push({ path: '/' });
    },
    updateLang(state, lang) {
      state.cards = [];
      state.lang = lang;
    },
    getCards(state, cards) {
      cards.forEach(card => {
        state.cards.push(card);
      });
    },
    resetAllCard(state) {
      state.cards = [];
      state.card = [];
    },
    getCard(state, card) {
      state.card = card;
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
    getCard(state) {
      return state.card;
    },
  },
  actions: {
    getMyInfo({ commit, state }) {
      try {
        axios
          .get('api/auth/myinfo', {
            headers: {
              'Content-Type': `application/json`,
              Authorization: 'Bearer ' + state.token,
            },
          })
          .then(res => {
            if (res.status === 200) {
              // 로그인 성공시 처리해줘야할 부분
              commit('getMyInfo', res.data.myInfo);
            }
          });
      } catch (error) {
        console.error(error);
      }
    },
    getCards({ commit, state }, { cardType, page }) {
      axios
        .get(`/api/card/${state.lang}/${cardType}cardindex?page=${page}`, {
          headers: {
            'Content-Type': `application/json`,
            Authorization: 'Bearer ' + state.token,
          },
        })
        .then(response => {
          commit('getCards', response.data.data);
        })
        .catch(function (error) {
          console.error(error);
        });
    },
    getCard({ commit, state }, code) {
      axios
        .get(`/api/card/${state.lang}/show/${code}`, {
          headers: {
            'Content-Type': `application/json`,
            Authorization: 'Bearer ' + state.token,
          },
        })
        .then(response => {
          commit('getCard', response.data);
        })
        .catch(function (error) {
          console.error(error);
        });
    },
  },
};

export default userStore;
