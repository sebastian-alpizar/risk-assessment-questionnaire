import { defineStore } from 'pinia';
import axios from 'axios';
const api = import.meta.env.VITE_API_URL

export const useEvaluacionesStore = defineStore("evaluaciones", {
  state: () => ({
    evaluaciones: [],
    cargado: false,
    cargando: false,
    error: null,
  }),
  actions: {
    async fetchEvaluaciones(usuarioId) {
      if (this.cargado || this.cargando) return; // ya cargado o cargando
      this.cargando = true;
      try {
        const res = await axios.get(
          `${api}/evaluaciones?usuario_id=${usuarioId}`
        );
        this.evaluaciones = res.data;
        this.cargado = true;
      } catch (err) {
        console.error("Error cargando evaluaciones", err);
        this.error = "Error al cargar evaluaciones";
      } finally {
        this.cargando = false;
      }
    },
    agregarEvaluacion(evaluacion) {
      this.evaluaciones.unshift(evaluacion); // agrega al inicio
    }
  },
});
