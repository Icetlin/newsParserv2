import { defineStore } from 'pinia';
import {computed, Ref, ref, UnwrapRef} from 'vue';
import { ParsedNews } from '@/interfaces/ParsedNews';
import { ParsedNewsService } from '@/services/ParsedNewsService';

const parserService = new ParsedNewsService();
let autoUpdateTimer: ReturnType<typeof setInterval> | null = null;

export const useNewsStore = defineStore('news', () => {
    const newsList: Map<number, ParsedNews> = new Map();
    const loading = ref(false);
    const page = ref(1);
    const itemsPerPage = ref(5);
    const newsAutoUpdateInterval = ref(100);
    let totalNews: Ref<number> = ref(0);
    const totalPages = computed(() => Math.ceil(totalNews.value / itemsPerPage.value));

    const fetchNews = async (
        customPage: number | null = null,
        customItemsPerPage: number | null = null
    ) => {
        if (loading.value) return;
        loading.value = true;
        try {
            if (page.value > totalPages.value && page.value !== 1 ) {
                itemsPerPage.value = totalNews.value
                page.value = 1
            }
            const response = await parserService.fetchParsedNews({
                page: customPage === null ?  page.value : customPage,
                itemsPerPage: customItemsPerPage === null ? itemsPerPage.value : customItemsPerPage,
            });

            totalNews.value = response.meta.totalItems
            for (let i = 0; i <= response.data.length - 1; i++) {
                let oneNews = response.data[i]
                let oneNewsId = oneNews['attributes']['_id']
                newsList.set(oneNewsId, oneNews)
            }
        } catch (error) {
            console.error('Error fetching news:', error);
        } finally {
            loading.value = false;
        }
    };

    const setPage = (pageNumber: number) => {
        page.value = pageNumber;
    };

    const setNewsAutoUpdateInterval = (interval: number) => {
        newsAutoUpdateInterval.value = interval;
    };

    const setNewsPerPage = (perPage: number) => {
        itemsPerPage.value = perPage;
    };

    const autoFetchNews = async () => {
        autoUpdateTimer = setInterval(async () => {
            await fetchNews(
                1,
                newsList.size === 0 ? itemsPerPage.value : newsList.size
            );
            await updateNewsRating(newsList)
        }, newsAutoUpdateInterval.value * 1000);
    }


    const stopAutoUpdate = () => {
        if (autoUpdateTimer) {
            clearInterval(autoUpdateTimer);
            autoUpdateTimer = null;
        }
    };

    const updateNewsRating = async (newsList: Map<number, ParsedNews> ) => {
        await parserService.updateNewsRating(newsList)
    }

    const deleteNews = async (id: number) => {
        await parserService.deleteNews(id)
    }

    return {
        newsList,
        loading,
        page,
        itemsPerPage,
        newsAutoUpdateInterval,
        autoFetchNews,
        deleteNews,
        fetchNews,
        setPage,
        setNewsAutoUpdateInterval,
        setNewsPerPage,
        stopAutoUpdate,
    };
});
