import router from '../../router/index.js';

const userStore = {
  state: {
    // userId: '',
    // userName: '',
    token: '',
  },
  mutations: {
    login(state, payload) {
      // state.userId = payload.userId;
      // state.userName = payload.userName;
      state.token = payload.token;
      console.log(state.token);
      router.push({ path: '/card' });
    },
    loginCheck(state) {
      if (!state.token) {
        router
          .push({
            name: 'login',
          })
          .catch(error => {
            console.log(error);
          });
      } else {
        return true;
      }
    },
    logout(state) {
      state.token = '';
      router.push({ path: '/' });
    },
  },
  getters: {},
  actions: {},
};

export default userStore;
