import {ref, readonly, unref} from 'vue';

export const useAsync = (clb: (loading: boolean) => Promise<any>) => {
    const loading = ref(false);

    async function dispatch() {
        loading.value = true;

        let result;

        try {
            result = await clb(unref(loading));
        } catch (e) {
            console.error(e);
        } finally {
            loading.value = false;
        }

        return result;
    }

    return {
        loading: readonly(loading),
        dispatch,
    };
};