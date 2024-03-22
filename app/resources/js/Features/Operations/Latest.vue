<script setup>
import {ref, onMounted, computed} from "vue";
import {useOperationsStore} from "~/Store/Operations";
import Button from "../../Components/Button.vue";

const operationsStore = useOperationsStore();

const operations = computed(() => operationsStore.latestOperations);

const isLoading = ref(true);

onMounted(async () => {
  isLoading.value = true;

  await operationsStore.fetchLatestOperations();

  isLoading.value = false;
});
</script>

<template>
  <div class="current-balance">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <table class="table">
            <thead>
            <tr>
              <th scope="col">Тип</th>
              <th scope="col">Сумма</th>
              <th scope="col">Описание</th>
              <th scope="col">Дата</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="operation in operations" :key="`latestOperationsItem-${operation.id}`">
              <td>{{ operation.type }}</td>
              <td>{{ operation.amount }}</td>
              <td>{{ operation.description }}</td>
              <td>{{ operation.date }}</td>
            </tr>
            </tbody>
          </table>

          <Button href="/operations">Все операции</Button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>
