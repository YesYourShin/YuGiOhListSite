<template>
  <app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            오리카 상세페이지
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
          {{ orica.attribute }} 속성
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
          <br>펜듈럼 효과 : <br> {{ orica.pEffect }}
        </div>
        <div class="my-4 text-subtitle-1" v-if="orica.monsterType">
          {{ orica.monsterType}} • {{ orica.monsterCategory }}
        </div>
        <div>효과 : <br>{{orica.effect}}</div>

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
          수정하기
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
      check: false
    }
  },
  mounted() {
    axios.get('http://localhost:8000/oricashow/'+this.orica.id)
      .then(response=>{
        axios.get('http://localhost:8000/oricacheck/'+this.orica.user_id)
          .then(response=>{
            if (response.data.check) {
              this.check = true;
            }
          })
          .catch (function (error) {
              console.error(error);
          })
      })
      .catch (function (error) {
        console.error(error);
      })
  },
  methods: {
    editCollection() {
      location.href=("http://localhost:8000/orica/"+this.orica.id+"/edit")
    },
    deleteCollection() {
      axios.delete('http://localhost:8000/oricadestroy/'+this.orica.id)
        .then(response=>{
          location.href="http://localhost:8000/oricalist"  
        })
        .catch (function (error) {
          console.error(error);
        })
    }
  }
}
</script>