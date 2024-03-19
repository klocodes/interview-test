<script setup>
import {ref, nextTick, onMounted} from 'vue';

const container = ref(null);

onMounted(async () => {
  // Ожидание отрисовки DOM
  await nextTick();

  // Получение SVG и всех путей внутри слота
  const svg = container.value.querySelector('svg');
  const paths = svg.querySelectorAll('path');

  // Проход по каждому пути и применение смещения
  paths.forEach(path => {
    const bbox = path.getBBox();
    const centerX = (svg.viewBox.baseVal.width - bbox.width) / 2 - bbox.x;
    const centerY = (svg.viewBox.baseVal.height - bbox.height) / 2 - bbox.y;

    path.setAttribute('transform', `translate(${centerX}, ${centerY})`);
  });
});
</script>

<template>
  <div class="icon-container" ref="container">
    <slot/>
  </div>
</template>
