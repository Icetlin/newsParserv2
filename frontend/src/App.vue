<!-- src/App.vue -->
<template>
  <div id="app">
    <NewsList />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import NewsList from '@/components/NewsList.vue';

export default defineComponent({
  name: 'App',
  components: {
    NewsList,
  },
});
</script>

<style>
html, body {
  height: 10px;
  margin: 0;
  padding: 0;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
