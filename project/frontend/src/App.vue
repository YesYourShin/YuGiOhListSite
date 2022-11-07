<template>
  <div id="app">
    <MenuBar />
    <!-- <img alt="Vue logo" src="./assets/logo.png" /> -->
    <!-- <HelloWorld msg="Welcome to Your Vue.js App" /> -->
    <CardList />
  </div>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue';
// import MenuBar from './components/MenuBar.vue';
// import CardList from './components/CardList.vue';
import { MenuBar, CardList } from './components/index.js';

export default {
  name: 'App',
  components: {
    // HelloWorld,
    MenuBar,
    CardList,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
