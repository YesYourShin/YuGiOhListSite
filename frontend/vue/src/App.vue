<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mr-2"
          contain
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          transition="scale-transition"
          width="40"
        />

        <v-img
          alt="Vuetify Name"
          class="shrink mt-1 hidden-sm-and-down"
          contain
          min-width="100"
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-name-dark.png"
          width="100"
        />
      </div>

      <v-btn>
        <router-link to="/CardList"><span class="mr-2">Card List</span></router-link>
      </v-btn>

      <v-btn>
        <router-link to="/MyCardList"><span class="mr-2">My Card List</span></router-link>
      </v-btn>

      <v-spacer></v-spacer>

      

      <v-btn
        href="https://github.com/vuetifyjs/vuetify/releases/latest"
        target="_blank"
        text
      >
        <router-link to="/CardList"><span class="mr-2">Latest Release</span></router-link>
        <v-icon>mdi-open-in-new</v-icon>
      </v-btn>
    </v-app-bar>
  <div id="app">
    <ul>
    <li><router-link to="/">게시판</router-link></li>
    <li><router-link to="/signup">회원가입</router-link></li>
    </ul>
  <router-view/>
  </div>
  </v-app>
</template>

<script>

export default {
  name: 'App',

  components: {
  },

  data: () => ({
    //
  }),
};
</script>
