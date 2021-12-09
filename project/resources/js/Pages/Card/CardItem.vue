<template>
  <app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            카드 상세페이지
        </h2>
    </template>
    <v-card
      class="mx-auto my-12"
      max-width="374"
    >
      <template slot="progress">
        <v-progress-linear
          color="deep-purple"
          height="10"
          indeterminate
        ></v-progress-linear>
      </template>

      <v-card-title>{{card.title}}</v-card-title>

      <v-card-text>
        <div v-if="card.icon">
          {{ card.icon }}
        </div>
        <div v-if="card.attribute">
          {{ card.attribute }} 속성
        </div>
        <div v-if="card.level">
          <br>레벨 {{ card.level }}
        </div>
        <div v-if="card.rank">
          <br>랭크 {{ card.rank }}
        </div>
        <div v-if="card.pScale">
          <br>펜듈럼 스케일 {{ card.pScale }}
        </div>
        <div v-if="card.link">
          <br>링크 {{ card.link }}
        </div>
        <div v-if="card.pEffect">
          <br>펜듈럼 효과 <br> {{ card.pEffect }}
        </div>
        <div class="my-4 text-subtitle-1" v-if="card.monsterType">
          {{ card.monsterType }} • {{ card.cardType }}
        </div>
        <div>효과 : <br>{{card.effect}}</div>
      
        <v-divider class="mx-4"></v-divider>

        <div v-if="card.atk">
          ATK {{ card.atk }}
        </div>
        <div v-if="card.def">
          DEF {{ card.def }} 
        </div>
      </v-card-text>

      <v-card-text v-if="card.limited">
        <v-chip>{{ card.limited }}</v-chip>
      </v-card-text>

      <v-card-actions>
        <!-- <input type="text"
          v-model="number"
          size=17
          label="title"
          > -->
        <v-text-field
          v-model="number"
          :counter="5"
          label="개수"
          required
        ></v-text-field>

        <v-btn v-if="check==false"
          color="deep-purple lighten-2"
          text
          @click="addCollection"
        >
          추가하기
        </v-btn>
        <v-btn v-if="check==true"
          color="deep-purple lighten-2"
          text
          @click="editCollection"
        >
          변경하기
        </v-btn>
        <v-btn v-if="check==true"
          color="deep-purple lighten-2"
          text
          @click="deleteCollection"
        >
          삭제하기
        </v-btn>
      </v-card-actions>
    </v-card>
  </app-layout>
</template>

<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout'
export default {
  components: {AppLayout},
  props: ['response', 'id'],
  data() {
    return {
      card: '',
      number: '',
      check: false
    }
  },
  mounted() {
      this.card = this.response;
      axios.get('http://localhost:8000/collectionshow/'+this.card.id)
      .then(response=>{
        if(response.data.collection) {
          this.number = response.data.collection.number;
          this.check=true;
        }
      })
      .catch (function(error) {
        console.error(error);
      })
  },
  methods: {
    addCollection() {
      if(this.number == null) {
        alert('가진 카드 갯수를 입력해주세요.');
        return;
      }
      axios.post('http://localhost:8000/collectioninsert', {title: this.card.title, number: this.number, card_id: this.card.id})
        .then(response=>{
          this.check = true;
        })
        .catch (function (error) {
          console.error(error);
        })
    },
    editCollection() {
      axios.patch('http://localhost:8000/collectionupdate/'+this.card.id, {number: this.number, card_id: this.card.id})
        .then(response=>{
          
        })
        .catch (function (error) {
          console.error(error);
        })
    },
    deleteCollection() {
      axios.delete('http://localhost:8000/collectiondestroy/'+this.card.id)
        .then(response=>{
          this.check=false;
          this.number='';
        })
        .catch (function (error) {
          console.error(error);
        })
    }
  }
}
</script>