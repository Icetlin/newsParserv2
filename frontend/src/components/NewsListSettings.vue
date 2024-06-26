<template>
  <div class="news-list-settings">
    <div class="news-list-items-per-page-selector-wrapper">
      <p>Load news per scroll</p>
      <select
          name="news-list-items-per-page-selector"
          id="news-list-items-per-page-selector"
          class="news-list-items-per-page-selector"
          v-model="newsPerPage"
          @change="setNewsPerPageAndUpdate(newsPerPage)"
      >
        <option v-for="item in newsListSettingsArray" :key="item" :value="item">{{ item }}</option>
      </select>
    </div>
    <div class="news-list-auto-update-wrapper">
      <p>Auto update interval</p>
      <select
          name="news-list-auto-update"
          id="news-list-auto-update"
          class="news-list-auto-update"
          v-model="newsAutoUpdateInterval"
          @change="setAutoUpdateIntervalAndUpdate(newsAutoUpdateInterval)"
      >
        <option v-for="item in newsListSettingsArray" :key="item" :value="item">{{ item }}</option>
      </select>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useNewsStore } from "@/store/news";

export default defineComponent({
  name: 'NewsListSettings',
  setup() {
    const newsStore = useNewsStore();
    const newsPerPage = ref(newsStore.itemsPerPage);
    const newsAutoUpdateInterval = ref(newsStore.newsAutoUpdateInterval);
    const newsListSettingsArray = Array.from({ length: 100 }, (_, index) => index + 1);
    const newsAutoUpdateVariants = Array.from({ length: 101 }, (_, index) => index);

    function setNewsPerPageAndUpdate($newsPerPage:number) {
      newsStore.setNewsPerPage($newsPerPage)
      newsStore.setPage(1)
      newsStore.fetchNews()

    }

    function setAutoUpdateIntervalAndUpdate($interval:number) {
      newsStore.stopAutoUpdate();
      newsStore.setNewsAutoUpdateInterval($interval);
      newsStore.autoFetchNews();
    }


    return {
      newsPerPage,
      newsListSettingsArray,
      setNewsPerPageAndUpdate,
      setAutoUpdateIntervalAndUpdate,
      newsAutoUpdateInterval,
      newsAutoUpdateVariants
    };
  }
})
</script>

<style scoped>
.news-list-items-per-page-selector{
  width: fit-content;
}
.news-list-items-per-page-selector-wrapper {
  padding-bottom: 16px;
  border-bottom: 2px solid rgba(20, 41, 65, 0.25);
}
.news-list-auto-update-wrapper {
  padding-bottom: 16px;
  border-bottom: 2px solid rgba(20, 41, 65, 0.25);
}
</style>
