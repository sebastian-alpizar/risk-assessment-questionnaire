import { defineStore } from 'pinia'
import axios from 'axios'

const api = import.meta.env.VITE_API_URL

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,   // guarda el usuario logueado
    isLoggedIn: false,
    errors: [],
    success: ''
  }),

  actions: {
    async login(usuario_id, password) {
      this.errors = []
      try {
        const res = await axios.post(`${api}/auth/login`, {
          usuario_id,
          password
        })

        this.user = res.data.usuario
        this.isLoggedIn = true

        // Guardar en localStorage
        localStorage.setItem('userId', res.data.usuario.usuario_id)
        localStorage.setItem('userName', res.data.usuario.responsable)
        localStorage.setItem('empresa', res.data.usuario.empresa)

        return true // para que el componente pueda redirigir
      } catch (err) {
        if (err.response?.data?.errors) {
          this.errors = Object.values(err.response.data.errors).flat()
        } else if (err.response?.data?.message) {
          this.errors = [err.response.data.message]
        } else {
          this.errors = ['Error desconocido']
        }
        return false
      }
    },

    async register({ empresa, responsable, usuario_id, password, password_confirmation }) {
      this.errors = []
      this.success = ''

      try {
        const res = await axios.post(`${api}/auth/register`, {
          empresa,
          responsable,
          usuario_id,
          password,
          password_confirmation
        })

        this.success = res.data.message
        return true
      } catch (err) {
        if (err.response?.data?.errors) {
          this.errors = Object.values(err.response.data.errors).flat()
        } else if (err.response?.data?.message) {
          this.errors = [err.response.data.message]
        } else {
          this.errors = ['Error desconocido']
        }
        return false
      }
    },

    logout() {
      this.user = null
      this.isLoggedIn = false
      localStorage.clear()
    },

    checkAuth() {
      // restaurar desde localStorage
      const userId = localStorage.getItem('userId')
      const userName = localStorage.getItem('userName')
      const empresa = localStorage.getItem('empresa')

      if (userId && userName) {
        this.user = { usuario_id: userId, responsable: userName, empresa }
        this.isLoggedIn = true
      }
    }
  }
})
