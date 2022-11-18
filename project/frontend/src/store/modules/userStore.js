import router from '../../router/index.js';

const userStore = {
  state: {
    myInfo: {
      email: '',
      nickname: '',
    },
    token: '',
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
  },
  getters: {
    isNotLogin(state) {
      // 로그인이 안 되어 있으면 페이지를 안 보여줌
      if (state.token) {
        // 로그인이 되어 있을 경우
        alert('잘못된 요청입니다.');
        router.push({ path: '/' });
        return false;
      }
      // 로그인이 안 되어 있을 경우
      return true;
    },
  },
  actions: {},
};

export default userStore;
