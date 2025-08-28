import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/Home.vue';
import Login from '@/views/Login.vue';
import About from '@/views/About.vue';
import ListEvaluations from '@/components/ListEvaluations.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/historico', component: ListEvaluations },
  { path: '/about', component: About }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router