<template>
    <div class="pyramid-loader">
        <div class="wrapper">
            <span class="side side1"></span>
            <span class="side side2"></span>
            <span class="side side3"></span>
            <span class="side side4"></span>
            <span class="shadow"></span>
        </div>
    </div>
</template>

<style scoped>
  .wrapper {
    animation: spin 6s linear infinite;
  }
  @keyframes spin {
    100% {
      transform: rotateY(360deg);
    }
  }
</style>