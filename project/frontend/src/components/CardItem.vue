<template>
  <div>
    <div v-if="card != 'Not Found' && card">
      <p>CardItem</p>
      <div>{{ code }} 페이지 입니다.</div>
      <div class="flex">
        <div>
          <img :src="require(`../assets/black_magic_girl.jpg`)" />
        </div>

        <div>
          <p>Name: {{ card.name }}</p>
          <p v-if="this.lang == 'ja'">Hiragana: {{ card.name2 }}</p>
          <p>Card Text: {{ card.card_text }}</p>
        </div>
      </div>

      <div v-for="(item, index) in card.cardNumber" v-bind:key="item.id" v-bind:id="index">
        <p>Card Number: {{ item.card_number }}</p>
        <p>Pack Name: {{ item.pack_name }}</p>
        <p>Rare: {{ item.rare }}</p>
        <input v-if="isLogin" v-bind:value="item.amount" v-bind:id="item.id" type="amount" placeholder="amount" class="input input-bordered" v-on:keyup.enter="cardSubmit" required />
      </div>
    </div>
    <div v-if="card == 'Not Found'">
      <p>Not Found</p>
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
      amount: null,
    };
  },
  computed: {
    token() {
      return this.$store.getters.getToken;
    },
    isLogin() {
      // 로그인이 되어 있는지 체크
      return this.$store.getters.isLogin;
    },
    lang() {
      return this.$store.getters.getLang;
    },
    card() {
      return this.$store.getters.getCard;
    },
  },
  watch: {
    lang: {
      // 최초 실행을 하게 해줌
      immediate: true,
      handler() {
        this.getCard();
      },
    },
    isLogin() {
      this.getCard();
    },
  },
  methods: {
    cardSubmit(event) {
      const saveData = {};
      saveData.cardNumberId = event.target.id;
      saveData.amount = event.target.value;
      const index = event.target.parentElement.id;
      // 입력한 숫자가 이전 숫자와 동일할 경우 return
      // v-model로 card의 amount와 이어져 있어서 입력이 바뀌면 card에서도 바뀌기 때문에
      // input태그의 name에 기존의 amount 값을 입력해 놓고 비교했음
      if (!event.target.value) {
        alert('값을 입력해주세요.');
        return;
      }
      if (this.card.cardNumber[index].amount == event.target.value) {
        alert('변경하려는 카드 값이 현재 값과 같습니다.');
        return;
      }

      try {
        axios
          .post(`/api/card/${this.lang}/mycardstore`, JSON.stringify(saveData), {
            headers: {
              'Content-Type': `application/json`,
              Authorization: 'Bearer ' + this.token,
            },
          })
          .then(response => {
            if (response.status === 200) {
              this.getCard();
              if (response.data === 'Not Found') {
                alert('유효한 값을 입력해주세요.');
              }
              if (response.data === 'create success') {
                alert('카드를 추가하였습니다.');
              }
              if (response.data === 'update success') {
                alert('소지 수량을 변경하였습니다.');
              }
              if (response.data === 'delete success') {
                alert('카드를 삭제하였습니다.');
              }
            }
          });
      } catch (error) {
        console.error(error);
      }
    },
    getCard() {
      return this.$store.dispatch('getCard', this.code);
    },
  },
  destroyed() {
    // 페이지에서 나갈 때 vuex store에 있는 카드 변수를 비워줌
    this.$store.commit('resetAllCard');
  },
};
</script>
