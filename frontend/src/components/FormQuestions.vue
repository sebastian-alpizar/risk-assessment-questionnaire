<template>
  <div class="main-container">
    <div class="container">
        <form class="form-container">
            <label class="text-lg sm:text-xl">Filtrar preguntas</label>
            <div class="form-checkbox-norms">
              <label>Norma evaluada</label>

              <div class="checkbox-norms-subgrid">
                <SquareCheckbox v-model="selectedNorm" value="ISO 27001" label="ISO 27001" />
                <SquareCheckbox v-model="selectedNorm" value="ISO 27002" label="ISO 27002" />
                <SquareCheckbox v-model="selectedNorm" value="ISO 27003" label="ISO 27003" />
                <SquareCheckbox v-model="selectedNorm" value="COBIT 4.1" label="COBIT 4.1" />
              </div>
            </div>

            <div class="form-checkbox-risks">
              <label>Riesgo</label>

              <div class="checkbox-risks-subgrid">
                <SquareCheckbox v-model="selectedRisks" value="Integridad" label="Integridad"/>
                <SquareCheckbox v-model="selectedRisks" value="Disponibilidad" label="Disponibilidad"/>
                <SquareCheckbox v-model="selectedRisks" value="Confidencialidad" label="Confidencialidad"/>
              </div>
              
            </div>

            <button type="button" @click="guardarEvaluacion">Guardar</button>
        </form>

        <div class="semaphore-container">
            <transition-group name="slide">
                <Semaphore
                v-for="(percentage, risk) in resultsFromListQuestions" 
                :key="risk"
                :label="risk" 
                :percentage="parseFloat(percentage)"
                class="semaphore-item"
                />
            </transition-group>
        </div>
    </div>
  </div>
  <ListQuestions
    ref="listQuestions"
    :risk="selectedRisks" 
    :norms="selectedNorm"
    @update:results="resultsFromListQuestions = $event"
  />
</template>

<script>
import SquareCheckbox from './SquareCheckbox.vue';
import RoundCheckbox from './RoundCheckbox.vue';
import ListQuestions from './ListQuestions.vue';
import Semaphore from './Semaphore.vue';
import { useEvaluacionesStore } from '../stores/Evaluaciones';

const userId = localStorage.getItem("userId");
const empresa = localStorage.getItem("empresa");
const api = import.meta.env.VITE_API_URL

export default {
  components: {
    SquareCheckbox,
    RoundCheckbox,
    ListQuestions,
    Semaphore
  },
  data() {
    // Define las variables que están vinculadas a los inputs.
    return {
      company: '',
      date: '',
      responsible: '',
      selectedRisks: ["Integridad"],
      selectedNorm: [],
      resultsFromListQuestions: {}
    };
  },
  watch: {
    selectedRisks(newVal, oldVal) {
      // Si intentan deseleccionar todos -> restaurar el último estado
      if (newVal.length === 0) {
        this.$nextTick(() => {
          this.selectedRisks = oldVal
        })
        return
      }

      // Riesgos eliminados = estaban en oldVal pero ya no en newVal
      const removed = oldVal.filter(risk => !newVal.includes(risk));
      if (removed.length > 0) {
        this.$refs.listQuestions?.clearAnswersByRisks(removed);
      }
    }
  },
  methods: {
    async guardarEvaluacion() {
      const store = useEvaluacionesStore();
      try {
        // recolectar respuestas del hijo
        const respuestas = [];
        const answers = this.$refs.listQuestions.answers;
        for (const [preguntaId, respuesta] of Object.entries(answers)) {
          if (respuesta) {
            respuestas.push({ id_pregunta: preguntaId, respuesta });
          }
        }

        const payload = {
          usuario_id: userId,
          empresa: empresa,
          respuestas,
          resultados: this.resultsFromListQuestions
        };

        const res = await axios.post(`${api}/evaluaciones`, payload);
        alert("Evaluación guardada correctamente!");
        store.agregarEvaluacion(res.data.evaluacion);
        this.$refs.listQuestions.clearAllAnswers();
      } catch (err) {
        console.error(err);
        alert("Error al guardar la evaluación!");
      }
    }
  }
}
</script>

<style scoped>
.form-container {
  animation: gradient 5s ease infinite;
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }

  50% {
    background-position: 100% 50%;
  }

  100% {
    background-position: 0% 50%;
  }
}

        /* Animaciones para el semaforo */
.slide-enter-active {
  animation: slideInFromRight 1s forwards;
}

.slide-leave-active {
  animation: slideOutToRight 1s forwards;
  position: absolute; /* Importante para el layout durante la animación */
}

@keyframes slideInFromRight {
  from {
    opacity: 0;
    transform: translateX(100%);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slideOutToRight {
  from {
    opacity: 1;
    transform: translateX(0);
  }
  to {
    opacity: 0;
    transform: translateX(100%);
  }
}
</style>