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
    resetAllCard(state) {
      console.log('카드 리스트와 정보 리셋');
      state.cards = [];
      state.card = [];
    },
    getCard(state, code) {
      axios
        .get(`/api/card/${state.lang}/show/${code}`, {
          headers: {
            'Content-Type': `application/json`,
            Authorization: 'Bearer ' + state.token,
          },
        })
        .then(response => {
          state.card = response.data;
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
              console.log('유저 정보 가져오기 성공!');

              commit('getMyInfo', res.data.myInfo);
            }
          });
      } catch (error) {
        console.log('에러');
        console.error(error);
      }
    },
    getCards({ commit, state }, page) {
      console.log('page', page);
      axios
        .get(`/api/card/${state.lang}/allcardindex?page=${page}`)
        .then(response => {
          commit('getCards', response.data.data);
        })
        .catch(function (error) {
          console.error(error);
        });
    },
  },
};

export default userStore;
