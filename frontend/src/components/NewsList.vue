<template>
  <div class="container">
    <div class="news-list-settings">
      <NewsListSettings></NewsListSettings>
    </div>
    <div class="news-list-wrapper">
      <div class="news-list-header">
        <p class="news-list-header-news-title">
          News
        </p>
        <p class="news-list-header-rating-title">
          Rating
        </p>
      </div>
      <div class="news-list" @scroll="onScroll">
        <NewsItem
            v-for="[id, news] in Array.from(newsStore.newsList)"
            :key="id"
            :news="news"
        />
        <div v-if="newsStore.loading" class="loading">Loading...</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue';
import NewsListSettings from "@/components/NewsListSettings.vue";
import NewsItem from './NewsItem.vue';
import { useNewsStore } from '@/store/news';

const newsStore = useNewsStore();

const onScroll = (event: Event) => {
  const target = event.target as HTMLElement;
  if (target.scrollTop + target.clientHeight >= target.scrollHeight) {
    newsStore.stopAutoUpdate();
    newsStore.page += 1
    newsStore.fetchNews();
    newsStore.autoFetchNews();
  }
};

onMounted(() => {
  newsStore.fetchNews();
  newsStore.stopAutoUpdate();
  newsStore.autoFetchNews();
});
</script>

<style scoped>
.container {
  display: flex;
  height: 100vh;
}

.news-list {
  flex-grow: 1;
  overflow-y: auto;
  padding-left: 16px;
  padding-right: 16px;
  padding-bottom: 16px;
}

.loading {
  text-align: center;
  padding: 16px;
}

.news-list-settings {
  background-color: #75b798;
  width: 100px;
}

.news-list-header {
  height: 20px;
  display: flex;
  width: 100%;
  background-color: rgb(255, 255, 255);
  padding-top: 16px;
  padding-bottom: 16px;
}

.news-list-wrapper {
  display: flex;
  flex-direction: column;
}

.news-list-header-news-title {
  width: 90%;
  margin: 0px;
}

.news-list-header-rating-title {
  width: 10%;
  margin: 0px;
  text-align: left;
}
</style>
