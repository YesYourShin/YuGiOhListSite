<template>
  <div id="app">
    <MenuBar />
    <div><router-view></router-view></div>
  </div>
</template>

<script>
import { MenuBar } from './components/index.js';

export default {
  name: 'App',
  components: {
    MenuBar,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  /* color: #2c3e50; */
  margin-top: 60px;
}
</style>
