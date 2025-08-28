<template>
  <div class="loader-wrapper">
    <div class="loader-label">
      <span>{{ label }}</span>
      <span>{{ percentage }}%</span>
    </div>

    <div class="loader">
      <div
        class="loader-circle"
        v-for="i in 3"
        :key="i"
        :class="{ active: isActive(i) }"
        :style="{ backgroundColor: getActiveColor(i) }"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Semaphore",
  props: {
    label: { type: String, default: "Cargando" },
    percentage: { type: Number, default: 0 }
  },
   methods: {
    getActiveColor(index) {
      const pct = Math.min(Math.max(this.percentage, 0), 100);
      if (pct <= 33 && index === 1) return "#aa0000"; // rojo oscuro
      else if (pct > 33 && pct <= 66 && index === 2) return "#cc6600"; // naranja oscuro
      else if (pct > 66 && index === 3) return "#009900"; // verde oscuro
      return "#222"; // apagado
    },
    isActive(index) {
      const pct = Math.min(Math.max(this.percentage, 0), 100);
      return (pct <= 33 && index === 1) || (pct > 33 && pct <= 66 && index === 2) || (pct > 66 && index === 3);
    }
  }
};
</script>

<style scoped>
/* Neon y parpadeo del círculo activo */
.loader-circle.active {
  animation: neonBlink 1.5s infinite;
  box-shadow: 0 0 10px currentColor, 0 0 20px currentColor, 0 0 30px currentColor;
}

/* Animación de parpadeo */
@keyframes neonBlink {
  0%, 100% {
    opacity: 1;
    box-shadow: 0 0 5px currentColor, 0 0 15px currentColor, 0 0 25px currentColor;
  }
  50% {
    opacity: 0.6;
    box-shadow: 0 0 15px currentColor, 0 0 30px currentColor, 0 0 40px currentColor;
  }
}
</style>