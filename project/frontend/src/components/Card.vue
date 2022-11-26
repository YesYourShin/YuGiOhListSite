<template>
  <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
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
        <tr v-for="item in cards" v-bind:key="item.code" @click="onClick(item.code)" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
// import axios from 'axios';
export default {
  name: 'CardList',
  data() {
    return {
      page: 1,
    };
  },
  computed: {
    cards() {
      return this.$store.getters.getCards;
    },
    lang() {
      return this.$store.getters.getLang;
    },
  },
  watch: {
    lang: {
      // 최초 실행을 하게 해줌
      immediate: true,
      handler() {
        this.getCards();
      },
    },
  },
  methods: {
    onClick(code) {
      this.$router.push({ path: `card/${code}` });
    },
    getCards() {
      this.$store.dispatch('getCards', { cardType: 'all', page: this.page });
    },
  },
  destroyed() {
    // 페이지에서 나갈 때 vuex store에 있는 카드 변수를 비워줌
    this.$store.commit('resetAllCard');
  },
};
</script>
