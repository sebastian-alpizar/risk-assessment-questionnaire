<template>
  <div class="preguntas-container">
    <h2 class="preguntas-title">Listado de Preguntas</h2>

    <transition name="slide-fade">
      <table v-if="preguntasFiltradas.length" class="preguntas-table">
        <thead class="preguntas-thead">
          <tr>
            <th class="preguntas-th">Actividad</th>
            <th class="preguntas-th">Pregunta</th>
            <th class="preguntas-th">Sí</th>
            <th class="preguntas-th">No</th>
            <th class="preguntas-th">N/A</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pregunta in preguntasFiltradas" :key="pregunta.id_pregunta">
            <td class="preguntas-td">{{ pregunta.tarea.nombre }}</td>
            <td class="preguntas-td">{{ pregunta.texto }}</td>
            <td class="preguntas-check">
              <RoundCheckbox 
                :name="'pregunta-' + pregunta.id_pregunta"
                v-model="answers[pregunta.id_pregunta]" 
                value="si"
              />
            </td>
            <td class="preguntas-check">
              <RoundCheckbox 
                :name="'pregunta-' + pregunta.id_pregunta"
                v-model="answers[pregunta.id_pregunta]" 
                value="no"
              />
            </td>
            <td class="preguntas-check">
              <RoundCheckbox 
                :name="'pregunta-' + pregunta.id_pregunta"
                v-model="answers[pregunta.id_pregunta]" 
                value="na"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </transition>
  </div>
</template>

<script setup>
import { onMounted, computed, watch } from "vue"
import RoundCheckbox from "./RoundCheckbox.vue"
import { storeToRefs } from 'pinia'
import { usePreguntasStore } from '../stores/Preguntas'

const store = usePreguntasStore()

const { preguntas, cargando, error, answers } = storeToRefs(store)

const props = defineProps({
  risk: {
    type: Array,
    default: () => []
  },
  norms: {
    type: Array,
    default: () => []
  }
})

onMounted(() => {
  store.fetchPreguntas()
  emit('update:results', cumplimientoPorRiesgo.value)
})

// Computed que devuelve preguntas filtradas por riesgo y norma
const preguntasFiltradas = computed(() => {
  return preguntas.value.filter(p => {
    // Filtrar por riesgos si hay alguno seleccionado
    const matchRisk =
      props.risk.length === 0 || props.risk.includes(p.tipo_cia)

    // Filtrar por normas si hay alguna seleccionada
    const matchNorm =
      props.norms.length === 0 || props.norms.includes(p.tarea?.norma?.nombre)

    return matchRisk && matchNorm
  })
})

// Computed para calcular cumplimiento por riesgo
const cumplimientoPorRiesgo = computed(() => {
  const resultados = {}

  props.risk.forEach(r => {
    const preguntasDelRiesgo = preguntasFiltradas.value.filter(p => p.tipo_cia === r)
    if (preguntasDelRiesgo.length === 0) {
      resultados[r] = 0
      return
    }

    let sumaValores = 0
    const sumaMaxima = preguntasDelRiesgo.length

    preguntasDelRiesgo.forEach(p => {
      const respuesta = answers.value[p.id_pregunta]

      if (!respuesta) return // Ignorar preguntas no respondidas

      let valorNum = 0
      if (respuesta === 'si') valorNum = 1
      else if (respuesta === 'na') valorNum = 0
      sumaValores += valorNum
    })

    resultados[r] = ((sumaValores / sumaMaxima) * 100).toFixed(1)
  })

  return resultados
})

// Emitir los resultados cuando cambien
const emit = defineEmits(['update:results'])

watch(cumplimientoPorRiesgo, (newVal) => {
  emit('update:results', newVal)
}, { deep: true })

function clearAnswersByRisks(removedRisks) {
  preguntas.value.forEach(p => {
    if (removedRisks.includes(p.tipo_cia)) {
      answers.value[p.id_pregunta] = null
    }
  })
}

function clearAllAnswers() {
  preguntas.value.forEach(p => {
    answers.value[p.id_pregunta] = null
  })
}

// expone la función al padre
defineExpose({
  clearAnswersByRisks,
  clearAllAnswers,
  answers
})
</script>