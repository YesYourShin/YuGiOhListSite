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
      } else {
        return true;
      }
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
  getters: {},
  actions: {},
};

export default userStore;
