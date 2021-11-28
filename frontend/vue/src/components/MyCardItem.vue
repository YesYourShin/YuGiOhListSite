<template>
  <v-card
    :loading="loading"
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

    <v-card-title>{{card.title}}</v-card-title>

    <v-card-text>
      <v-row
        align="center"
        class="mx-0"
      >
      
      <v-if>
        
        <v-rating
          :value="10"
          color="amber"
          dense
          half-increments
          readonly
          size="14"
        ></v-rating>
        
      </v-if>
      
      </v-row>

      <div class="my-4 text-subtitle-1">
        $ • Italian, Cafe
      </div>

      <div>{{card.effect}}</div>
    </v-card-text>

    <v-divider class="mx-4"></v-divider>

    <v-card-title>Tonight's availability</v-card-title>

    <v-card-text>
      <v-chip-group
        v-model="selection"
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip>5:30PM</v-chip>

        <v-chip>7:30PM</v-chip>

        <v-chip>8:00PM</v-chip>

        <v-chip>9:00PM</v-chip>
      </v-chip-group>
    </v-card-text>

    <v-card-actions>
      <v-text-field
        v-model="number"
        clearable
        flat
        solo-inverted
        hide-details
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
</template>

<script>
import axios from 'axios';
export default {
    data() {
      return {
        id: this.$route.params.id,
        card: '',
        number: '',
        check: false
      }
    },
    created() {
      axios.get('http://localhost:8000/collectioncardshow/'+this.id)
      .then(response=>{
        console.log(response);
        this.card = response.data;
        axios.get('http://localhost:8000/collectionshow/'+this.card.title)
        .then(response=>{
          console.log('success');
          console.log(response);
          this.number = response.data.number;
          if(this.number > 0){
this.check=true;
          }
          
        })
        .catch (function(error) {
          console.log(this.card.title);
          console.error(error);
        })
      })
      .catch (function (error) {
                console.error(error);
            })
    },
    methods: {
      addCollection() {
        if(this.number == null) {
          alert('가진 카드 갯수를 입력해주세요.');
          return;
        }
        axios.post('http://localhost:8000/collectioninsert/', {title: this.card.title, number: this.number})
        .then(response=>{
        console.log(response.data);
        this.check = true;
        
      })
      .catch (function (error) {
                console.error(error);
            })
      },
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