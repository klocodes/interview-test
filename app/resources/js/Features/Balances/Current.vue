<script setup>
import {ref, onMounted, computed, onBeforeMount} from "vue";
import {useAuthStore} from "../../Store/Auth";
import {useBalanceStore} from "../../Store/Balance";

const authStore = useAuthStore();
const balanceStore = useBalanceStore();

const user = computed(() => authStore.user);
const balance = computed(() => balanceStore.balance);

const isLoading = ref(true);

onMounted(async () => {
  isLoading.value = true;

  await authStore.fetch();
  await balanceStore.fetchCurrentBalance();

  isLoading.value = false;
});
</script>

<template>
  <div class="current-balance" v-if="!isLoading">
    <div class="row">
      <div class="col-md-4">
        <h4 class="h3">Привет, {{ user.name }}</h4>
        <p class="text-body-secondary">Ваш баланс: {{ balance.amount }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>
