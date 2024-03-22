<script setup>

import History from "../Features/Operations/History.vue";
</script>

<template>
  <div class="operations">
    <div class="container">
      <div class="mb-3">
        <a href="/" class="btn btn-link">
          <i class="bi bi-arrow-left"></i>
          Назад
        </a>
      </div>

      <div class="card">
        <div class="card-body">
          <h1 class="h3 operations__title">История операций</h1>

          <div class="operations__history">
            <History />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.operations {
  padding: 50px 0;

  &__title {
    margin-bottom: 20px;
  }
}
</style>
