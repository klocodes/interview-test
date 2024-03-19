<script setup>
import Header from "~/Components/Header.vue";
import Sidebar from "~/Components/Sidebar.vue";
</script>

<template>
  <div class="layout">
    <Header/>

    <Sidebar/>

    <main class="content">
      <slot/>
    </main>
  </div>
</template>

<style scoped lang="scss">
.layout {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  grid-template-rows: auto 1fr auto;
  grid-gap: 30px;
  height: 100vh;
}

.content {
  grid-column: 4 / 13;
  background-color: $palette-box;
  border-radius: 10px;
  box-shadow: $box-shadow;
  margin: 0 30px 0 0;
}


.footer {
  background-color: $palette-box;
  padding: 20px;
  color: $palette-text;
  grid-column: 1 / 13;
  height: 40px;

  &__text {
    text-align: center;
  }
}

</style>
