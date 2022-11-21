<template>
  <div v-if="isLogin" class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="py-3 px-6">Name</th>
          <th scope="col" class="py-3 px-6">Color</th>
          <th scope="col" class="py-3 px-6">Category</th>
          <th scope="col" class="py-3 px-6">Price</th>
          <th scope="col" class="py-3 px-6">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in cards" v-bind:key="item.id" @click="onClick(item.code)" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ item.name }}</th>
          <td class="py-4 px-6">Sliver</td>
          <td class="py-4 px-6">Laptop</td>
          <td class="py-4 px-6">$2999</td>
          <td class="py-4 px-6">
            <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'MyCard',
  data() {
    return {
      cards: [],
    };
  },
  computed: {
    isLogin() {
      // 로그인이 되어 있는지 체크
      return this.$store.getters.isLogin;
    },
    getLang() {
      return this.$store.getters.getLang;
    },
  },
  watch: {
    getLang() {
      this.getCard();
    },
  },
  mounted() {
    console.log('MyCardList');

    // 로그인이 되어있지 않을 경우
    if (!this.isLogin) {
      // 로그인이 되어 있을 경우
      alert('잘못된 요청입니다.');
      this.$router.push({ path: '/' });
      return;
    }
    this.getCard();
  },
  methods: {
    onClick(code) {
      console.log(code);
      this.$router.push({ path: `card/${code}` });
    },
    getCard() {
      axios
        .get(`/api/card/${this.getLang}/usercardshow`, {
          headers: {
            'Content-Type': `application/json`,
            Authorization: 'Bearer ' + this.$store.state.userStore.token,
          },
        })
        .then(response => {
          console.log('my card data', response.data.data);
          this.cards = response.data.data;
        })
        .catch(function (error) {
          console.error(error);
        });
    },
  },
};
</script>
