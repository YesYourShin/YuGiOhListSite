<template>
  <div>
    <div v-if="$route.query.page > 0 && $route.query.page <= pages.lastPage" class="overflow-x-auto relative shadow-md sm:rounded-lg">
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
      <div>
        <a id="previous" @click="getPreviousPage">← </a>
        <input id="page" type="page" v-bind:value="$route.query.page ? $route.query.page : 1" v-on:keyup.enter="getPage" />/{{ pages.lastPage }}
        <a id="next" @click="getNextPage">→</a>
      </div>
    </div>
    <div v-if="$route.query.page < 1 || $route.query.page > pages.lastPage">해당 페이지를 로드할 수 없습니다.</div>
  </div>
</template>
<script>
export default {
  name: 'CardList',
  computed: {
    cards() {
      return this.$store.getters.getCards;
    },
    lang() {
      return this.$store.getters.getLang;
    },
    pages() {
      return this.$store.getters.getPages;
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
  mounted() {
    console.log('카드', this.$route.query);
  },
  methods: {
    onClick(code) {
      this.$router.push({ path: `card/${code}` });
    },
    getPreviousPage() {
      if (this.$route.query.page - 1 < 1) {
        alert('해당 페이지를 로드할 수 없습니다.');
        return;
      }
      const page = parseInt(this.$route.query.page) - 1;
      this.$router.push({ name: 'CardList', query: { page: page } });
    },
    getNextPage() {
      if (this.$route.query.page + 1 > this.pages.lastPage) {
        alert('해당 페이지를 로드할 수 없습니다.');
        return;
      }
      const page = parseInt(this.$route.query.page) + 1;
      this.$router.push({ name: 'CardList', query: { page: page } });
    },
    getPage(e) {
      if (e.target.page < 1 || e.target.page > this.pages.lastPage) {
        alert('해당 페이지를 로드할 수 없습니다.');
        return;
      }
      const page = parseInt(e.target.value);
      this.$router.push({ name: 'CardList', query: { page: page } });
    },
    getCards() {
      const page = this.$route.query.page;
      this.$store.dispatch('getCards', { cardType: 'all', page: page });
    },
  },
  destroyed() {
    // 페이지에서 나갈 때 vuex store에 있는 카드 변수를 비워줌
    this.$store.commit('resetAllCard');
    this.$store.commit('resetPage');
  },
};
</script>
