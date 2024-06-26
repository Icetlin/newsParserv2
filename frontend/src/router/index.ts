import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router'
import NewsList from "@/components/NewsList.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'NewsList',
    component: NewsList
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
