<template>
  <div class="wrapper-form" :class="{ 'wrapper-login': !isSignup, 'wrapper-signup': isSignup }">
          <div class="card-switch">
              <label class="switch">
                 <input class="toggle" type="checkbox" v-model="isSignup">
                 <span class="slider"></span>
                 <span class="card-side"></span>
                 <div class="flip-card__inner">
                    <div class="flip-card__front">
                       <div class="title">Log in</div>
                       <form @submit.prevent="login" method="POST" class="flip-card__form">
                          <input v-model="usuario_id" type="text" placeholder="ID" name="usuario_id" class="flip-card__input">
                          <input v-model="password" type="password" placeholder="Password" name="password" class="flip-card__input">
                          <button class="flip-card__btn">Log!</button>
                          <!-- Mensajes de error -->
                          <div v-if="auth.errors.length" class="errors">
                            <ul>
                              <li v-for="(error, index) in auth.errors" :key="index">{{ error }}</li>
                            </ul>
                          </div>
                       </form>
                    </div>
                    <div class="flip-card__back">
                       <div class="title">Sign up</div>
                       <form @submit.prevent="register" method="POST" class="flip-card__form">
                          <input v-model="empresa" type="name" placeholder="Empresa/Organizacion" class="flip-card__input">
                          <input v-model="responsable"  type="text" placeholder="Persona entrevistada" name="responsable" class="flip-card__input">
                          <input v-model="usuario_id" type="text" placeholder="ID" name="usuario_id" class="flip-card__input">
                          <input v-model="password" type="password" placeholder="Password" name="password" class="flip-card__input">
                          <input v-model="password_confirmation" type="password" placeholder="Confirm Password" name="password_confirmation" class="flip-card__input">
                          <button class="flip-card__btn">Confirm!</button>
                          <!-- Mensajes de error -->
                          <div v-if="auth.errors.length" class="errors">
                            <ul>
                              <li v-for="(error, index) in auth.errors" :key="index">{{ error }}</li>
                            </ul>
                          </div>
                       </form>
                    </div>
                 </div>
              </label>
          </div>
     </div>
</template>

<script setup>
import { ref } from 'vue'
import {useRouter} from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

// Campos del formulario
const empresa = ref('')
const responsable = ref('')
const usuario_id = ref('')
const password = ref('')
const password_confirmation = ref('')
const isSignup = ref(false)

// Función de login
const login = async () => {
  const ok = await auth.login(usuario_id.value, password.value)
  if (ok) router.push('/')
}

const register = async () => {
  const ok = await auth.register({
    empresa: empresa.value,
    responsable: responsable.value,
    usuario_id: usuario_id.value,
    password: password.value,
    password_confirmation: password_confirmation.value
  })

  if (ok) {
    empresa.value = ''
    responsable.value = ''
    usuario_id.value = ''
    password.value = ''
    password_confirmation.value = ''
  }
}
</script>