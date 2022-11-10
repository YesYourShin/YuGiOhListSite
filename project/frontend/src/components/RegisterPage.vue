<template>
  <v-app id="app">
    <v-main>
      <v-container style="position: relative; top: 20%; margin-left: 20%" class="text-xs-center">
        <v-layout row wrap class="text-xs-center">
          <v-flex>
            <v-card flat class="mx-auto" max-width="800">
              <v-row style="margin-top: 60px">
                <v-col>
                  <v-form style="width: 400px; height: 300px">
                    <div class="mx-3">
                      <v-icon color="black" size="30px">person</v-icon>
                      name
                      <div class="mx-1">
                        <input ckass="text-white" placeholder="name" v-model="name" required />
                      </div>
                    </div>
                    <div class="mx-3">
                      <v-icon color="black" size="30px">person</v-icon>
                      email
                      <div class="mx-1">
                        <input placeholder="email" v-model="email" required />
                      </div>
                    </div>
                    <div class="mx-3">
                      <v-icon color="black" size="30px">lock</v-icon>
                      password
                      <div class="mx-1">
                        <input placeholder="password" type="password" v-model="password" required />
                      </div>
                    </div>

                    <v-card-actions>
                      <v-btn color="#2c4f91" dark large block @click="registerSubmit">Register</v-btn>
                    </v-card-actions>
                  </v-form>
                </v-col>
              </v-row>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      name: null,
      email: null,
      password: null,
    };
  },
  methods: {
    registerSubmit() {
      let saveData = {};
      saveData.name = this.name;
      saveData.email = this.email;
      saveData.password = this.password;

      try {
        axios
          .post('api/register', JSON.stringify(saveData), {
            headers: {
              'Content-Type': `application/json`,
            },
          })
          .then(res => {
            if (res.status === 200) {
              // 로그인 성공시 처리해줘야할 부분
              console.log('회원가입 성공!');
              console.log('로그인 페이지로 가서 로그인을!');
              // console.log(res.data);

              this.$router.push({ path: '/login' });
            }
          });
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
