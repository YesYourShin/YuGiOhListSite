<template>
  <v-form v-model="orica">
    <v-container>

    <v-select
      v-model="category"
      :items="categoryItems"
      label="Item"
      required
      @change="categoryCheck"
    ></v-select>

    <div v-if="category=='몬스터'">

    <v-select
      v-model="monsterCategory"
      :items="monsterCategoryItems"
      label="Item"
      required
      @change="monsterCategoryCheck"
    ></v-select>

        <div v-if="monsterCategory">
        <v-text-field
            v-model="title"
            :counter="10"
            label="title"
            required
          ></v-text-field>


    <v-select
      v-model="attribute"
      :items="attributeItems"
      label="attribute"
      required
    ></v-select>

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
        <v-select
      v-model="icon"
      :items="iconItems"
      :rules="[v => !!v || 'Item is required']"
      label="icon"
      required
    ></v-select>

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
                <v-select
      v-model="icon"
      :items="iconItems"
      :rules="[v => !!v || 'Item is required']"
      label="icon"
      required
    ></v-select>

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
</template>

<script>
import axios from 'axios';
  export default {
    data: () => ({
      orica: '',
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
        linkArray: '',
        monsterType: '',
        effect: '',
        atk: '',
        def: '',

    //   levelRules: [
    //     v => !!v || 'Input Number',
    //     v => /.+@.+/.test(v) || 'E-mail must be valid',
    //   ],
      
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
          },

          
          makeOrica() {
        //       if(this.number == null) {
        //   alert('가진 카드 갯수를 입력해주세요.');
        //   return;
        // }
        let router = this.$router
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
            console.log(orica);
        console.log(response);
        router.push("/oricalist");
        
      })
      .catch (function (error) {
                console.error(error);
            })
          }
      }
  }
</script>