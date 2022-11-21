<template>
  <div v-if="!isLogin" class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col lg:flex-row-reverse">
      <div class="text-center lg:text-left">
        <h1 class="text-5xl font-bold">Register now!</h1>
        <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
      </div>
      <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
        <div class="card-body">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Name</span>
            </label>
            <input type="text" placeholder="name" class="input input-bordered" v-model="name" required />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Email</span>
            </label>
            <input type="text" placeholder="email" class="input input-bordered" v-model="email" required />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Password</span>
            </label>
            <input type="password" placeholder="password" class="input input-bordered" v-model="password" required />
            <label class="label">
              <!-- <a href="#" class="label-text-alt link link-hover">Forgot password?</a> -->
            </label>
            <label class="label">
              <a class="label-text-alt link link-hover">
                <router-link to="/login">Login</router-link>
              </a>
            </label>
          </div>
          <div class="form-control mt-6">
            <button class="btn btn-primary" @click="registerSubmit">Register</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      name: null,
      email: null,
      password: null,
      // isLogin: false,
    };
  },
  computed: {
    isLogin() {
      // 로그인이 되어 있는지 체크
      return this.$store.getters.isLogin;
    },
  },
  mounted() {
    if (this.isLogin) {
      // 로그인이 되어 있을 경우
      alert('잘못된 요청입니다.');
      this.$router.push({ path: '/' });
    }
  },
  methods: {
    registerSubmit() {
      let saveData = {};
      saveData.name = this.name;
      saveData.email = this.email;
      saveData.password = this.password;

      try {
        axios
          .post('api/auth/register', JSON.stringify(saveData), {
            headers: {
              'Content-Type': `application/json`,
            },
          })
          .then(res => {
            if (res.status === 200) {
              // 로그인 성공시 처리해줘야할 부분
              console.log('회원가입 성공!');
              console.log('로그인 페이지로 가서 로그인을!');
              // console.log(res.data);

              this.$router.push({ path: '/login' });
            }
          });
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
