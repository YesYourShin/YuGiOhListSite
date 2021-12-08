<template>
<app-layout>
  <v-form>
    <v-container>

      <select v-model="category" required @change="categoryCheck()">
        <option v-for="(c, index) in categoryItems"  :key="index" >
          {{ c }}
        </option>
      </select>
<!-- <select class="form-control">
      <option :key="i" :value="d.v" v-for="(d, i) in options">{{ d.t }}</option>
    </select> -->

    <!-- <v-select
      v-model="category"
      :items="categoryItems"
      label="Item"
      required
      @change="categoryCheck"
    ></v-select> -->

    <div v-if="category=='몬스터'">

      <select v-model="monsterCategory" @change="monsterCategoryCheck()">
        <option v-for="(mc, index) in monsterCategoryItems"  :key="index">
          {{ mc }}
        </option>
      </select>

    <!-- <v-select
      v-model="monsterCategory"
      :items="monsterCategoryItems"
      label="Item"
      required
      @change="monsterCategoryCheck"
    ></v-select> -->

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

    <!-- <v-select
      v-model="attribute"
      :items="attributeItems"
      label="attribute"
      required
    ></v-select> -->

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
            readonly
          >
          </v-text-field>    

      <select v-model="linkArray" v-if="monsterCategory=='링크'" required multiple='multiple'>
        <option v-for="(a, index) in linkArrayItems"  :key="index">
          {{ a }}
        </option>
      </select>

        <v-text-field
            v-model="monsterType"
            label="monsteType"
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
        <option v-for="(i, index) in iconItems"  :key="index">
          {{ i }}
        </option>
      </select>

        <!-- <v-select
      v-model="icon"
      :items="iconItems"
      :rules="[v => !!v || 'Item is required']"
      label="icon"
      required
    ></v-select> -->

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

                <!-- <v-select
      v-model="icon"
      :items="iconItems"
      :rules="[v => !!v || 'Item is required']"
      label="icon"
      required
    ></v-select> -->

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
        @click="editOrica"
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
    props: ['response'],
    data: () => ({
      selected:'',
      category: '',
      categoryItems: ['몬스터', '마법', '함정'],
      monsterCategory: '',
      monsterCategoryItems: ['엑시즈', '펜듈럼', '링크', '그외'],
      icon: '',
      iconItems: '',
      title: '',
      attribute: null,
      attributeItems: ['어둠', '빛', '땅', '물', '화염', '바람', '신'],
        level: '',
        rank: '',
        pScale: '',
        pEffect: '',
        link: '',
        linkArray: [],
        linkArrayItems: ['←', '→', '↑', '↓', '↖', '↙', '↗', '↘'],
        monsterType: '',
        effect: '',
        atk: '',
        def: '',
        validation: [
          v => !!v || 'title is required'
        ]

    //   levelRules: [
    //     v => !!v || 'Input Number',
    //     v => /.+@.+/.test(v) || 'E-mail must be valid',
    //   ],
      
    }),
    mounted() {
      console.log(this.response);
      let res = this.response
      this.category= res.category;
      if(this.category=="몬스터") {
        this.monsterCategory= res.monsterCategory;
        this.title= res.title;
        this.attribute= res.attribute;
        this.monsterType= res.monsterType;
        this.effect= res.effect;
        this.atk= res.atk;
        this.def= res.def;
        if(this.monsterCategory=="엑시즈") {
          this.rank= res.rank;
        }
        if(this.monsterCategory=="펜듈럼") {
          this.level= res.level;
          this.pScale= res.pScale;
          this.pEffect= res.pEffect;
        }
        if(this.monsterCategory=="링크") {
          this.link= res.link;
          this.linkArray= res.linkArray;
        }
        if(this.monsterCategory=="그외") {
          this.level= res.level;
        }
        
      }
      if(this.category=="마법") {
        this.icon= res.icon;
        this.iconItems = ['일반 마법', '지속 마법', '장착 마법', '속공 마법', '필드 마법',' 의식 마법']
        this.title= res.title;
        this.effect= res.effect;
        
      }
      if(this.category=="함정") {
        this.icon= res.icon;
        this.iconItems = ['일반 함정', '지속 함정', '카운터 함정']
        this.title= res.title;
        this.effect= res.effect;
      }
      
    },
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
              } else {
                if(this.def == "-") {
                  this.def = "";
                return;
                }
                return;
              }
          },

          
          editOrica() {
        //       if(this.number == null) {
        //   alert('가진 카드 갯수를 입력해주세요.');
        //   return;
        // }
        // if(this.category == "몬스터" &&
        // (this.monsterCategory== '' ||
        // this.title== '' ||
        // this.attribute== '' ||
        // this.monsterType== '' ||
        // this.effect== '' ||
        // this.atk== '' ||
        // this.def== '' )) {
        //   alert('no');
        //   return


        // }

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
        axios.patch('http://localhost:8000/oricaupdate/'+this.response.id, orica)
        .then(response=>{
            console.log(response.data.id);
        
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