<template>
  <div class="navbar bg-base-100">
    <div class="flex-1">
      <router-link to="/">
        <a class="flex items-center">
          <img src="../assets/yugioh-dark-magician-girl.png" class="mr-3 h-6 sm:h-9" alt="black_magic_girl" />
          <!-- <a class="btn btn-ghost normal-case text-xl">daisyUI</a> -->
          <span class="btn btn-ghost normal-case text-xl">YuGiOh Card Management</span>
        </a>
      </router-link>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal p-0">
        <li>
          <a><router-link to="/card">Card</router-link></a>
        </li>
        <li>
          <a><router-link to="/mycard">MyCard</router-link></a>
        </li>
        <li>
          <!-- <select class="select select-bordered w-full max-w-xs" @change="updateLang(lang)">
            <option disabled selected>Language</option>
            <option value="ko">한국어</option>
            <option value="ja">日本語</option>
          </select> -->
          <select v-model="lang">
            <option v-for="language in languages" v-bind:key="language.value">{{ language.country }}</option>
          </select>
        </li>
      </ul>
    </div>

    <div v-if="getToken" class="dropdown dropdown-end">
      <label>{{ myInfo.email }}</label>
      <label>{{ myInfo.nickname }}</label>
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img src="../assets/evil_twin_Ki-sikil.jpg" />
        </div>
      </label>
      <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
        <li><a>Settings</a></li>
        <li><a @click="logout">Logout</a></li>
      </ul>
    </div>
    <div v-else class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img src="../assets/yugioh_icon.png" />
        </div>
      </label>
      <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
        <li><a @click="register">Register</a></li>
        <li><a @click="login">Login</a></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      languages: [
        {
          country: 'ko',
          value: 1,
        },
        {
          country: 'ja',
          value: 2,
        },
      ],
      lang: '',
    };
  },
  computed: {
    getToken() {
      return this.$store.getters.getToken;
    },
    getLang() {
      return this.$store.getters.getLang;
    },
    myInfo() {
      return this.$store.getters.getMyInfo;
    },
  },
  watch: {
    lang() {
      console.log('변경됨');
      console.log(this.lang);
      this.$store.commit('updateLang', this.lang);
    },
  },
  mounted() {
    // 진짜 mounted로 해야되는가? select에서 할 수 없나?
    this.lang = this.getLang;
    // console.log('lang', this.lang);
  },
  methods: {
    login() {
      if (this.$route.path !== '/login') this.$router.push({ path: '/login' });
    },
    register() {
      if (this.$route.path !== '/register') this.$router.push({ path: '/register' });
    },
    logout() {
      this.$store.commit('logout');
    },
  },
};
</script>
