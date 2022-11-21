<template>
  <div>
    <p>CardItem</p>
    <div>{{ id }} 페이지 입니다.</div>
    <div class="flex">
      <div>
        <img :src="require(`../assets/black_magic_girl.jpg`)" />
      </div>

      <div>
        <p>Name: {{ card.name }}</p>
        <p>Hiragana: {{ card.name2 }}</p>
        <p>Card Text: {{ card.card_text }}</p>
      </div>
    </div>

    <div v-for="item in card.cardNumber" v-bind:key="item.id">
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
      id: this.$route.params.id,
      card: [],
    };
  },
  created() {
    this.getCard();
  },
  methods: {
    getCard() {
      axios
        .get(`/api/card/ja/show/${this.id}`)
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
