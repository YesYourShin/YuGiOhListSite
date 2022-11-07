<template>
  <div>CardList</div>
</template>
<script>
import axios from 'axios';
export default {
  name: 'CardList',
  mounted() {
    console.log('CardList');
    this.test();

    const index = axios
      .get('/jp/index')
      .then(response => {
        console.log(response);
      })
      .catch(function (error) {
        console.error(error);
      });
    console.log(index);
  },
  methods: {
    test() {
      console.log('test');
    },
  },
};
</script>
