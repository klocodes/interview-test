<script setup>
import {useAuthStore} from "~/Store/Auth";

import Exit from "~/Icons/Exit.vue";

const authStore = useAuthStore()

const logout = async () => {
  await authStore.logout()
}
</script>

<template>
  <div
      @click="logout"
      class="logout"
  >
    <Exit/>

    <div class="logout-title">Выйти</div>
  </div>
</template>

<style scoped lang="scss">
  .logout {
    display: flex;
    align-items: center;
    gap: 3px;
    cursor: pointer;
    text-transform: uppercase;
    color: $palette-text;

    &:hover {
      color: $palette-accent-hover
    }
  }
</style>
