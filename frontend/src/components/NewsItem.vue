<template>
  <div :class="['news-item', { decreasedRating: isRatingDecreased }, { increasedRating: isRatingIncreased }]">
    <div class="news-item-rating">
      <p class="news-item-rating-text">
        {{ news.attributes.rating }}
      </p>
      <div class="news-item-rating-delete" @click="deleteNews(news.attributes._id)" >
        delete this news
      </div>
    </div>
    <div class="news-item-text-content">
      <h2 class="news-item-text-content-title">{{ news.attributes.title }}</h2>
      <details @toggle="isFullTextShown = !isFullTextShown">
        <summary class="news-item-text-content-details-summary">
          <span class="news-item" v-if="isFullTextShown">
              {{ news.attributes.content }}
          </span>
        </summary>
        <p>{{ news.attributes.content }}</p>
      </details>
      <a class="news-item-text-content-read-on-source" :href="news.attributes.newsUrl" target="_blank">Read on source</a>
      <small>{{ news.attributes.date }} | {{ news.attributes.source }}</small>
    </div>
  </div>
</template>

<script setup lang="ts">
import {ref, watch} from 'vue';
import { ParsedNews } from '@/interfaces/ParsedNews';
import {useNewsStore} from "@/store/news";

interface Props {
  news: ParsedNews;
}

const props = defineProps<Props>();
const isFullTextShown = ref(true);
let isRatingDecreased = ref(false);
let isRatingIncreased = ref(false);

const newsStore = useNewsStore();



const deleteNews = (id:number) => {
  newsStore.newsList.delete(id)
  newsStore.deleteNews(id)
}

watch(
    () => props.news.attributes.rating,
    (value, oldValue) => {
        if (value > oldValue) {
        isRatingIncreased.value = true;
        isRatingDecreased.value = false;
      } else if (value < oldValue) {
        isRatingIncreased.value = false;
        isRatingDecreased.value = true;
      }
    }
)



</script>

<style scoped>
.news-item {
  border-bottom: 1px solid #ddd;
  padding: 16px;
  display: flex;
  min-height: 150px;
  align-items: center;
  margin-bottom: 16px;
}
.news-item-text-content {
  width: 90%;
  height: 100%;
  min-width: 1000px;
}
.news-item-rating {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  width: 10%;
  flex-direction: column;
  min-width: 120px;
}
.news-item-rating-text {
  width: 100%;
  height: 100%;
  margin: 0px;
  overflow: hidden;
  font-size: 100px;
  color: rgba(133, 133, 133, 0.25);
  padding-right: 10px;

}

.news-item-text-content-details-summary {
  cursor: pointer;
  max-height: 80px;
  overflow: hidden;
  list-style: none;
  min-width: 200px;
  text-align: justify;
  margin-bottom: 10px;
}

details[open] summary ~ * {
  text-align: justify;
  margin-bottom: 10px;
}

.decreasedRating {
  background-color: rgba(219, 112, 112, 0.51);
  border-radius: 5px;
  border: 2px solid rgba(255, 0, 0, 0.55); /* Установите толщину и цвет границы */
}

.increasedRating {
  background-color: rgba(117, 183, 152, 0.49);
  border-radius: 5px;
  border: 2px solid rgba(3, 100, 0, 0.55); /* Установите толщину и цвет границы */
}
.news-item-text-content-read-on-source {
  margin-right: 10px;
}
.news-item-text-content-title {
  margin-top: 10px;
  margin-bottom: 10px;
}
.news-item-rating-delete{
  cursor: pointer;
}
</style>
