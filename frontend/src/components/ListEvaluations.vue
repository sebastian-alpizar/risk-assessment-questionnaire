<template>  
  <div class="evaluaciones-container">
    <h2 class="titulo-h2">Historial de Evaluaciones</h2>

    <transition-group name="slide-fade" tag="div">
      <div 
        v-for="eva in store.evaluaciones" 
        :key="eva.id" 
        class="card-evaluacion"
      >
        <h3 class="titulo-h3">
          Empresa evaluada: {{ eva.usuario.empresa }} — Responsable: {{ eva.usuario.responsable }}
        </h3>
        <p class="texto-fecha">Fecha: {{ new Date(eva.created_at).toLocaleString("es-CR") }}</p>

        <!-- porcentajes -->
        <div class="flex gap-4 mt-2">
          <span 
            v-if="eva.integridad !== '0.00'" 
            :class="clasePorcentaje(eva.integridad) + ' porcentaje'"
          >
            Integridad: {{ Math.round(parseFloat(eva.integridad)) }}%
          </span>
          <span 
            v-if="eva.confidencialidad !== '0.00'" 
            :class="clasePorcentaje(eva.confidencialidad) + ' porcentaje'"
          >
            Confidencialidad: {{ Math.round(parseFloat(eva.confidencialidad)) }}%
          </span>
          <span 
            v-if="eva.disponibilidad !== '0.00'" 
            :class="clasePorcentaje(eva.disponibilidad) + ' porcentaje'"
          >
            Disponibilidad: {{ Math.round(parseFloat(eva.disponibilidad)) }}%
          </span>
        </div>

        <!-- respuestas -->
        <table class="tabla-respuestas">
          <thead class="tabla-thead">
            <tr>
              <th class="tabla-th">Pregunta</th>
              <th class="tabla-th">Respuesta</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="resp in eva.respuestas" :key="resp.id">
              <td class="tabla-td text-left">{{ resp.pregunta?.texto }}</td>
              <td class="tabla-td">
                <span v-if="resp.respuesta === 'si'" class="respuesta-si">Sí</span>
                <span v-else-if="resp.respuesta === 'no'" class="respuesta-no">No</span>
                <span v-else class="respuesta-na">N/A</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useEvaluacionesStore } from "../stores/Evaluaciones";

const userId = localStorage.getItem("userId");
const store = useEvaluacionesStore();

onMounted(() => {
  store.fetchEvaluaciones(userId);
});

const clasePorcentaje = (valor) => {
  if (!valor || valor === '0.00') return '';
  const porcentaje = parseFloat(valor);
  if (porcentaje < 33) return 'rojo parpadeo';
  if (porcentaje <= 65) return 'naranja parpadeo';
  return 'verde parpadeo';
};

</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 2s ease-out;
}
.slide-fade-leave-active {
  transition: all 2s ease-in;
}
.slide-fade-enter-from {
  opacity: 0;
  transform: translateY(30px);
}
.slide-fade-enter-to {
  opacity: 1;
  transform: translateY(0);
}
.slide-fade-leave-from {
  opacity: 1;
  transform: translateY(0);
}
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

.evaluaciones-container {
  margin: 20px;
}
@keyframes parpadear {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.3; }
}

.parpadeo {
  animation: parpadear 1s infinite;
}

.rojo {
  background-color: #f33939; /* rojo claro */
  color: #7f1d1d;
}

.naranja {
  background-color: #fbc83c; /* naranja */
  color: #7c2d12;
}

.verde {
  background-color: #86efac; /* verde */
  color: #14532d;
}

@keyframes parpadearShadow {
  0%, 100% { box-shadow: 0 0 10px 0; }
  50% { box-shadow: 0 0 20px 5px currentColor; }
}

.parpadeo {
  animation: parpadearShadow 1s infinite;
}
</style>