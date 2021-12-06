<template>
        <app-layout>
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

    <v-img
      height="250"
      src="../../public/no_image.png"
    ></v-img>

    <v-card-title>{{orica.title}}</v-card-title>

    <v-card-text>

        <div v-if="orica.icon">
      {{ orica.icon }}
    </div> 
      <div v-if="orica.attribute">
       속성 {{ orica.attribute }}
    </div>


      <div v-if="orica.level">
       <br>레벨 {{ orica.level }}
    </div>

          <div v-if="orica.rank">
       <br>랭크 {{ orica.rank }}
    </div>

     <div v-if="orica.pScale">
       <br>펜듈럼 스케일 {{ orica.pScale }}
    </div>
    <div v-if="orica.link">
       <br>링크 {{ orica.link }}
    </div>

     <div v-if="orica.pEffect">
       <br>펜듈럼 효과 <br> {{ orica.pEffect }}
    </div>
 

      <div class="my-4 text-subtitle-1" v-if="orica.monsterType">
        {{ orica.monsterType}} • {{ orica.cardType }}
      </div>

      <div>{{orica.effect}}</div>
    

    <v-divider class="mx-4"></v-divider>

    <div v-if="orica.atk">
      ATK {{ orica.atk }}
    </div>
    <div v-if="orica.def">
      DEF {{ orica.def }} 
    </div>
</v-card-text>

    <v-card-actions>
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
    
    props: ['orica'],
    data() {
      return {
        orica: '',
        check: false
      }
    },
    mounted() {
      axios.get('http://localhost:8000/oricashow/'+this.orica.id)
      .then(response=>{
          console.log(response)
          let res = this.orica
        this.orica = res;
      })
      .catch (function (error) {
                console.error(error);
            })
    },
    methods: {
      editCollection() {
       // 카드 갯수가 바꼈을 때 처리
       axios.patch('http://localhost:8000/collectionupdate/'+this.card.title, {title: this.card.title, number: this.number})
      .then(response=>{
        console.log(response);
        console.log('edit done');
        
      })
      .catch (function (error) {
                console.error(error);
            })
      },
      deleteCollection() {
        // db에서 카드 데이터를 삭제하고 체크를 false로 바꾼다
         axios.delete('http://localhost:8000/collectiondestroy/'+this.card.title)
      .then(response=>{
        console.log(response);
        this.check=false;
        this.number='';
        console.log('delete done');
        
      })
      .catch (function (error) {
                console.error(error);
            })
      }
    }
}
</script>