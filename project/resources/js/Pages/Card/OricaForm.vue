<template>
  <app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            MakeOrica
        </h2>
    </template>
    <v-form ref="form" v-model="valid">
      <v-container>
        <label>카드 종류</label>
        <select v-model="category" required @change="categoryCheck()">
          <option v-for="(c, index) in categoryItems" :key="index" >
            {{ c }}
          </option>
        </select>

        
        <div v-if="category=='몬스터'">

        <label>몬스터 타입</label>
        <select v-model="monsterCategory" @change="monsterCategoryCheck()">
          <option v-for="(mc, index) in monsterCategoryItems" :key="index">
            {{ mc }}
          </option>
        </select>

        <div v-if="monsterCategory">
        <v-text-field
          v-model="title"
          :counter="255"
          label="카드 이름"
          :rules="titleRules"
          required
        ></v-text-field>

        <label>속성</label>
        <select v-model="attribute">
          <option v-for="(a, index) in attributeItems"  :key="index">
            {{ a }}
          </option>
        </select>

        <v-text-field v-if="(monsterCategory!=='엑시즈') && (monsterCategory!=='링크')"
          v-model="level"
          label="레벨"
          :rules="levelRules"
          required
        ></v-text-field>
        <v-text-field v-if="monsterCategory==='엑시즈'"
            v-model="rank"
            :rules="levelRules"
            label="랭크"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='펜듈럼'"
            v-model="pScale"
            :rules="pScaleRules"
            label="펜듈럼 스케일"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='펜듈럼'"
            v-model="pEffect"
            :counter="500"
            label="펜듈럼 효과"
            :rules="effectRules"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='링크'"
            v-model="link"
            label="링크"
            :rules="linkRules"
            required
          ></v-text-field>
        <v-text-field v-if="monsterCategory=='링크'"
            v-model="linkArray"
            label="링크 방향"
            :rules="linkArrayRules"
            required
          ></v-text-field>
        <v-text-field
            v-model="monsterType"
            label="몬스터 종족"
            :rules="monsterTypeRules"
            :counter="20"
            required
          ></v-text-field>
        <v-text-field
            v-model="effect"
            label="효과"
            :counter="500"
            :rules="effectRules"
            required
          ></v-text-field>          
        <v-text-field
            v-model="atk"
            label="공격력"
            :rules="atkRules"
            required
          ></v-text-field>          
        <v-text-field
            v-model="def"
            label="수비력"
            required
            :rules="defRules"
            :readonly="this.monsterCategory==='링크'"
          ></v-text-field>
        </div>
      </div>

      <div v-if="category=='마법'">
        <label>마법 종류</label>
        <select v-model="icon">
          <option v-for="(i, index) in iconItems" :key="index">
            {{ i }}
          </option>
        </select>
        <v-text-field
            v-model="title"
            :counter="255"
            label="카드 이름"
            :rules="titleRules"
            required
          ></v-text-field>
        <v-text-field
            v-model="effect"
            :counter="500"
            label="효과"
            :rules="effectRules"
            required
          ></v-text-field>
      </div>

      <div v-if="category=='함정'">
        <label>함정 종류</label>
        <select v-model="icon">
          <option v-for="(i, index) in iconItems" :key="index">
            {{ i }}
          </option>
        </select>
        <v-text-field
            v-model="title"
            :counter="255"
            label="제목"
            :rules="titleRules"
            required
          ></v-text-field>
        <v-text-field
            v-model="effect"
            :counter="500"
            label="효과"
            :rules="effectRules"
            required
          ></v-text-field>
        </div>
          <v-btn v-if="category"
          color="deep-purple lighten-2"
          text
        :disabled="!valid"
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
    valid: true,
    titleRules: [
      v => !!v || 'required',
      v => v.length <= 255 || v.length == undefined || '255자를 초과할 수 없습니다.',
    ],
    levelRules: [
      v => !!v || 'required',
      v => v >= 0 || '숫자만 입력해주세요.',
      v => v != 0 || '0은 입력할 수 없습니다.',
      v => v <= 13 || v.length == undefined || '13을 초과할 수 없습니다.',
    ],
    linkArrayRules: [
      v => !!v || 'required',
      v => v <= 0 || '숫자는 입력할 수 없습니다.',
      v => v.length <= 8 || v.length == undefined || '8을 초과할 수 없습니다.',
    ],
    linkRules: [
      v => !!v || 'required',
      v => v >= 0 || '숫자만 입력해주세요.',
      v => v != 0 || '0은 입력할 수 없습니다.',
      v => v <= 8 || v.length == undefined || '13을 초과할 수 없습니다.'
    ],
    monsterTypeRules: [
      v => !!v || 'required',
      v => v.length <= 20 || v.length == undefined || '20자를 초과할 수 없습니다.',
    ],
    effectRules: [
      v => !!v || 'required',
      v => v.length <= 500 || v.length == undefined || '500자를 초과할 수 없습니다.',
    ],
    pScaleRules: [
      v => !!v || 'required',
      v => v >= 0 || '숫자만 입력해주세요.',
      v => v <= 13 || v.length == undefined || '13을 초과할 수 없습니다.',
    ],
    atkRules: [
      v => !!v || 'required',
      v => v >= 0 || '숫자만 입력해주세요.',
      v => v.length <= 5 || v.length == undefined || '5자리를 넘길 수 없습니다.',
    ],
    defRules: [
      v => !!v || 'required',
      v => v == '-' || v >= 0 || '숫자만 입력해주세요.',
      v => v.length <= 5 || v.length == undefined || '5자리를 넘길 수 없습니다.',
    ],
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
          alert('모든 항목을 채워주세요.');
          return
        }
        else if(this.monsterCategory== '엑시즈' && this.rank=='') {
          alert('모든 항목을 채워주세요.');
          return
        }
        else if(this.monsterCategory== '펜듈럼' && ( this.level== ''|| this.pScale== ''||
                                                                      this.pEffect== '')) {
          alert('모든 항목을 채워주세요.');
          return
        }
        else if(this.monsterCategory== '링크' && (this.link== ''|| this.linkArray== '')) {
          alert('모든 항목을 채워주세요.');
          return
        }
        else if(this.monsterCategory== '그외' && this.level== '') {
          alert('모든 항목을 채워주세요.');
          return
        }
      }
      let orica
      if (this.category == "몬스터" && this.monsterCategory == "그외") {
          orica = {
            category: this.category,
            monsterCategory: this.monsterCategory,
            title: this.title,
            attribute: this.attribute,
            level: this.level,
            monsterType: this.monsterType,
            effect: this.effect,
            atk: this.atk,
            def: this.def,
          }
      } else if (this.category == "몬스터" && this.monsterCategory == "엑시즈") {
          orica = {
            category: this.category,
            monsterCategory: this.monsterCategory,
            title: this.title,
            attribute: this.attribute,
            rank: this.rank,
            monsterType: this.monsterType,
            effect: this.effect,
            atk: this.atk,
            def: this.def,
          }
      } else if (this.category == "몬스터" && this.monsterCategory == "펜듈럼") {
          orica = {
            category: this.category,
            monsterCategory: this.monsterCategory,
            title: this.title,
            attribute: this.attribute,
            level: this.level,
            pScale: this.pScale,
            pEffect: this.pEffect,
            monsterType: this.monsterType,
            effect: this.effect,
            atk: this.atk,
            def: this.def,
          }
      } else if (this.category == "몬스터" && this.monsterCategory == "링크") {
        orica = {
          category: this.category,
          monsterCategory: this.monsterCategory,
          title: this.title,
          attribute: this.attribute,
          link: this.link,
          linkArray: this.linkArray,
          monsterType: this.monsterType,
          effect: this.effect,
          atk: this.atk,
          def: this.def,
        }
      }

      if (this.category == "마법" || this.category == "함정") {
          orica = {
          title: this.title,
          category: this.category,
          icon: this.icon,
          effect: this.effect,
        }
      }
      axios.post('http://localhost:8000/oricainsert/', orica)
        .then(response=>{
          
      console.log(response)
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