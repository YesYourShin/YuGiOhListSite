<template>
  <div v-if="card">
    <p>CardItem</p>
    <div>{{ code }} 페이지 입니다.</div>
    <div class="flex">
      <div>
        <img :src="require(`../assets/black_magic_girl.jpg`)" />
      </div>

      <div>
        <p>Name: {{ card.name }}</p>
        <p v-if="this.getLang == 'ja'">Hiragana: {{ card.name2 }}</p>
        <p>Card Text: {{ card.card_text }}</p>
      </div>
    </div>

    <div v-for="item in card.cardNumber" v-bind:key="item.code">
      <p>Card Number: {{ item.card_number }}</p>
      <p>Pack Name: {{ item.pack_name }}</p>
      <p>Rare: {{ item.rare }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'CardItem',
  data() {
    return {
      code: this.$route.params.code,
      card: null,
    };
  },
  computed: {
    getLang() {
      return this.$store.getters.getLang;
    },
  },
  watch: {
    getLang() {
      this.getCard();
    },
  },
  created() {
    this.getCard();
  },
  methods: {
    getCard() {
      axios
        .get(`/api/card/${this.getLang}/show/${this.code}`)
        .then(response => {
          this.card = response.data;
        })
        .catch(function (error) {
          console.error(error);
        });
    },
  },
};
</script>
