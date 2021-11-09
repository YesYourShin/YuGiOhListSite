<template>
  <div>
    <v-container>
      <v-row class="mt-5">
        <h1>SIGNUP</h1>
      </v-row>
      <v-card class="mt-5">
        <v-form ref="form" v-model="valid" @submit.prevent="signup()" class="mx-10">
          
          <v-text-field 
            v-model ="name"
            label   ="NAME"
            required
            class="pt-10"
          ></v-text-field>

          <v-text-field 
            v-model ="email"
            label   ="EMAIL"
            required
            class="pt-6"
          ></v-text-field>

          <v-text-field 
            v-model ="password"
            label   ="PASSWORD"
            required
            class="pt-6"
            :append-icon="pswShow ? 'mdi-eye' : 'mdi-eye-off'"
            :type="pswShow ? 'text' : 'password'"
            v-on:click:append="pswShow = !pswShow"
          ></v-text-field>

          <v-text-field 
            v-model ="password_confirmation"
            label   ="Confirm Password"
            required
            class   ="pt-6"
            type    ="password"
          ></v-text-field>

          <v-row  justify="center">
            <router-link to="/">
            <v-btn 
              type="submit" 
              class="my-5" 
              :disabled="!valid" 
              width="300px" 
              color="primary" 
              @click="signup"
              >SINGUP
              </v-btn>
            </router-link>
          </v-row>

          <v-row class="py-7">
            <span>
              또는 <router-link to="/signin" >로그인</router-link>으로 돌아가기
            </span>
          </v-row>

        </v-form>
      </v-card>
    </v-container>
  </div>
</template>

<script>

import axios from 'axios'

export default {
  name: 'SignUp',
  data() {
    return {
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      pswShow: false,
      users:[],
      valid: false,
    }
  },

  methods: {
    signup() {
      const data = {
      name: this.name,
      email: this.email,
      password: this.password,
      }
      console.log(data);
    
      axios.post('http://localhost:8000/register', data)
      .then(function (response) {
          if (response.status === 200) {
              console.log(response)
          }
      })
      .catch (function (error) {
          console.error(error);
      });
    }
  }
}
</script>
