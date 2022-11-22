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
          <p v-if="this.getLang == 'ja'">Hiragana: {{ card.name2 }}</p>
          <p>Card Text: {{ card.card_text }}</p>
        </div>
      </div>

      <div v-for="(item, index) in card.cardNumber" v-bind:key="item.code" v-bind:id="index">
        <p>Card Number: {{ item.card_number }}</p>
        <p>Pack Name: {{ item.pack_name }}</p>
        <p>Rare: {{ item.rare }}</p>
        <input
          v-if="isLogin"
          v-model="item.amount"
          v-bind:id="item.id"
          v-bind:name="item.amount"
          type="amount"
          placeholder="amount"
          class="input input-bordered"
          v-on:keyup.enter="cardSubmit"
          required
        />
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
      card: null,
      amount: null,
    };
  },
  computed: {
    getToken() {
      return this.$store.getters.getToken;
    },
    isLogin() {
      // 로그인이 되어 있는지 체크
      return this.$store.getters.isLogin;
    },
    getLang() {
      return this.$store.getters.getLang;
    },
  },
  watch: {
    getLang: {
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
  mounted() {},
  methods: {
    cardSubmit(event) {
      let saveData = {};
      saveData.cardNumberId = event.target.id;
      saveData.amount = event.target.value;
      // 입력한 숫자가 이전 숫자와 동일할 경우 return
      // v-model로 card의 amount와 이어져 있어서 입력이 바뀌면 card에서도 바뀌기 때문에
      // input태그의 name에 기존의 amount 값을 입력해 놓고 비교했음
      if (event.target.name == event.target.value) {
        return;
      }
      try {
        axios
          .post(`/api/card/${this.getLang}/usercardstore`, JSON.stringify(saveData), {
            headers: {
              'Content-Type': `application/json`,
              Authorization: 'Bearer ' + this.getToken,
            },
          })
          .then(res => {
            console.log('res', res);
            this.getCard();
          });
      } catch (error) {
        console.error(error);
      }
    },
    getCard() {
      // 초기화 해주는 게 좋음 일단은
      this.card = null;
      axios
        .get(`/api/card/${this.getLang}/show/${this.code}`)
        .then(response => {
          this.card = response.data;
          this.getCardAmount();
        })
        .catch(function (error) {
          console.error(error);
        });
    },
    getCardAmount() {
      if (this.isLogin) {
        axios
          .get(`/api/card/${this.getLang}/usercardshow`, {
            headers: {
              'Content-Type': `application/json`,
              Authorization: 'Bearer ' + this.getToken,
            },
            params: { id: this.card.id },
          })
          .then(response => {
            for (let i = 0; i < response.data.length; i++) {
              const cardNumbers = this.card.cardNumber.map(cardNumber => {
                if (cardNumber.id == response.data[i].card_number_id) {
                  if (response.data[i].amount) {
                    cardNumber.amount = response.data[i].amount;
                  } else {
                    cardNumber.amount = '';
                  }
                }
                return cardNumber;
              });
              this.card.cardNumber = cardNumbers;
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      }
    },
  },
};
</script>
