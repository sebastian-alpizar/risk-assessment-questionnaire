<template>
    <header class="fixed top-0 left-0 w-full flex items-center justify-between p-7 h-25 px-3 z-50
     sm:px-10 bg-black text-sx sm:text-xl lg:text-2xl font-bold">

        <div class="flex items-center gap-4">
            <Logo/>
            <h1 class=" w-20 sm:w-50 lg:w-full">Cuestionario de Control Interno</h1>
        </div>

      <nav class="flex gap-2 items-center sm:gap-6">
        <router-link
          v-if="!auth.isLoggedIn && $route.path !== '/login'"
          to="/login"
          class="hover:underline"
        >
          Login
        </router-link>

        <router-link
          v-if="$route.path !== '/'"
          to="/"
          class="hover:underline"
        >
          Home
        </router-link>

        <router-link
          v-if="$route.path !== '/about'"
          to="/about"
          class="hover:underline"
        >
          About
        </router-link>

        <router-link
          v-if="auth.isLoggedIn && $route.path !== '/historico'"
          to="/historico"
          class="hover:underline"
        >
          Histórico
        </router-link>

        <button
          v-if="auth.isLoggedIn"
          @click="logout"
          class="hover:underline"
        >
          Logout
        </button>
      </nav>
    </header>
</template>

<script setup>
import Logo from './Logo.vue';
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth';
import { onMounted } from 'vue';

const router = useRouter()
const auth = useAuthStore()

// Restaurar sesión al cargar el header
onMounted(() => {
  auth.checkAuth()
})

const logout = () => {
  auth.logout()
  router.push('/login')
}
</script>