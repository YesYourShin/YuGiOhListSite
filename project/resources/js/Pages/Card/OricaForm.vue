<template>
  <app-layout>
    <v-form v-model="orica">
      <v-container>
        <select v-model="category" required @change="categoryCheck()">
          <option v-for="(c, index) in categoryItems" :key="index" >
            {{ c }}
          </option>
        </select>

        <div v-if="category=='몬스터'">

        <select v-model="monsterCategory" @change="monsterCategoryCheck()">
          <option v-for="(mc, index) in monsterCategoryItems" :key="index">
            {{ mc }}
          </option>
        </select>

        <div v-if="monsterCategory">
        <v-text-field
          v-model="title"
          :counter="10"
          label="title"
          required
        ></v-text-field>

        <select v-model="attribute">
          <option v-for="(a, index) in attributeItems"  :key="index">
            {{ a }}
          </option>
        </select>

        <v-text-field v-if="(monsterCategory!=='엑시즈') && (monsterCategory!=='링크')"
          v-model="level"
          label="level"
          required
        ></v-text-field>
        <v-text-field v-if="monsterCategory==='엑시즈'"
            v-model="rank"
            label="rank"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='펜듈럼'"
            v-model="pScale"
            label="pScale"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='펜듈럼'"
            v-model="pEffect"
            label="pEffect"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='링크'"
            v-model="link"
            label="link"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='링크'"
            v-model="linkArray"
            label="linkArray"
            required
          ></v-text-field>
        <v-text-field
            v-model="monsterType"
            label="monsterType"
            required
          ></v-text-field>
        <v-text-field
            v-model="effect"
            label="effect"
            required
          ></v-text-field>          
        <v-text-field
            v-model="atk"
            label="atk"
            required
          ></v-text-field>          
        <v-text-field
            v-model="def"
            label="def"
            required
            :readonly="this.monsterCategory==='링크'"
          ></v-text-field>
        </div>
      </div>

      <div v-if="category=='마법'">
        <select v-model="icon">
          <option v-for="(i, index) in iconItems" :key="index">
            {{ i }}
          </option>
        </select>
        <v-text-field
            v-model="title"
            :counter="10"
            label="title"
            required
          ></v-text-field>
        <v-text-field
            v-model="effect"
            :counter="10"
            label="effect"
            required
          ></v-text-field>
      </div>

      <div v-if="category=='함정'">

        <select v-model="icon">
          <option v-for="(i, index) in iconItems" :key="index">
            {{ i }}
          </option>
        </select>
        <v-text-field
            v-model="title"
            :counter="10"
            label="title"
            required
          ></v-text-field>
        <v-text-field
            v-model="effect"
            :counter="10"
            label="effect"
            required
          ></v-text-field>
        </div>
          <v-btn v-if="category"
          color="deep-purple lighten-2"
          text
          @click="makeOrica"
        >
          카드 만들기
        </v-btn>
      </v-container>
    </v-form>
  </app-layout>
</template>

<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout'
export default {
  components: {AppLayout},
  data: () => ({
    selected:'',
    orica: '',
    category: '',
    categoryItems: ['몬스터', '마법', '함정'],
    monsterCategory: '',
    monsterCategoryItems: ['엑시즈', '펜듈럼', '링크', '그외'],
    icon: '',
    iconItems: '',
    title: '',
    attribute: '',
    attributeItems: ['어둠', '빛', '땅', '물', '화염', '바람', '신'],
    level: '',
    rank: '',
    pScale: '',
    pEffect: '',
    link: '',
    linkArray: '',
    monsterType: '',
    effect: '',
    atk: '',
    def: '',
  }),
  methods: {
    categoryCheck() {
      if (this.category==='마법') {
        this.icon = '일반 마법'
        this.iconItems = ['일반 마법', '지속 마법', '장착 마법', '속공 마법', '필드 마법',' 의식 마법']
      }
      if (this.category==='함정') {
        this.icon = '일반 함정'
        this.iconItems = ['일반 함정', '지속 함정', '카운터 함정']
      }
      if (this.category==='몬스터') {
        this.monsterCategory = '그외'
      }else {
        this.monsterCategory = ''
      }
    },
    monsterCategoryCheck() {
      if(this.monsterCategory === '링크') {
        this.def = "-";
        return
      } 
      else {
        if(this.def == "-") {
          this.def = "";
          return;
        }
        return;
      }
    },
    makeOrica() {
      if(this.category == "몬스터" && (this.monsterCategory== '' || this.title== '' ||
                                      this.attribute== '' || this.monsterType== '' ||
                                      this.effect== '' || this.atk== '' ||
                                      this.def== '' )) {
        alert('모든 항목을 채워주세요.');
        return
      }
      if(this.category == "몬스터") {
        if(this.monsterCategory== '' || this.title== '' || this.attribute== '' ||
                                        this.monsterType== '' || this.effect== '' ||
                                        this.atk== '' || this.def== '' ) {
          alert('no');
          return
        }
        else if(this.monsterCategory== '엑시즈' && this.rank=='') {
          alert('no');
          return
        }
        else if(this.monsterCategory== '펜듈럼' && ( this.level== ''|| this.pScale== ''||
                                                                      this.pEffect== '')) {
          alert('no');
          return
        }
        else if(this.monsterCategory== '링크' && (this.link== ''|| this.linkArray== '')) {
          alert('no');
          return
        }
        else if(this.monsterCategory== '그외' && this.level== '') {
          alert('no');
          return
        }
      }
      let orica = {
        category: this.category,
        monsterCategory: this.monsterCategory,
        icon: this.icon,
        iconItems: this.iconItems,
        title: this.title,
        attribute: this.attribute,
        level: this.level,
        rank: this.rank,
        pScale: this.pScale,
        pEffect: this.pEffect,
        link: this.link,
        linkArray: this.linkArray,
        monsterType: this.monsterType,
        effect: this.effect,
        atk: this.atk,
        def: this.def,
      }
      axios.post('http://localhost:8000/oricainsert/', orica)
        .then(response=>{
          if(response.data.id) {
            location.href=("http://localhost:8000/oricashow/"+response.data.id)
          }

        })
        .catch (function (error) {
          console.error(error);
        })
    }
  }
}
</script>