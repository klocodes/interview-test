<script setup>
import {ref, onMounted, computed, reactive, watch} from "vue";
import {useOperationsStore} from "~/Store/Operations";
import Pagination from "~/Components/Pagination.vue";
import EditControl from "../../Components/EditControl.vue";
import Button from "../../Components/Button.vue";

const operationsStore = useOperationsStore();

const operationsCount = computed(() => operationsStore.operationsCount);
const operations = computed(() => operationsStore.operations);
const operationsDisplayLimit = computed(() => operationsStore.operationsDisplayLimit);

const queryParams = reactive({
  page: 1,
  search_string: '',
  sort_field: 'date',
  sort_direction: 'desc',
});

const isLoading = ref(true);

onMounted(async () => {
  isLoading.value = true;

  await operationsStore.fetchOperationsHistory(queryParams);

  isLoading.value = false;
});

watch(queryParams, async () => {
  isLoading.value = true;

  await operationsStore.fetchOperationsHistory(queryParams);

  isLoading.value = false;
}, {
  deep: true,
});

const sort = () => {
  queryParams.sort_direction = queryParams.sort_direction === 'asc' ? 'desc' : 'asc'
}

</script>

<template>
  <div class="operations-history">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <p class="text-body-secondary">Найдено: {{ operationsCount }}</p>
        </div>

        <div class="col-sm-4 offset-sm-2">
          <input class="form-control" placeholder="Поиск" v-model="queryParams.search_string"/>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="table-responsive">
            <table class="table">
              <thead>
              <tr>
                <th scope="col">Тип</th>
                <th scope="col">Сумма</th>
                <th scope="col">Описание</th>
                <th scope="col">
                  Дата
                  <span
                    class="btn btn-link"
                    @click="sort"
                  >
                  <i
                    class="bi"
                    :class="queryParams.sort_direction === 'asc' ? 'bi-caret-down-fill' : 'bi-caret-up-fill'"
                  ></i>
                </span>
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="operation in operations" :key="`historyOperationsItem-${operation.id}`">
                <td>{{ operation.type }}</td>
                <td>{{ operation.amount }}</td>
                <td>{{ operation.description }}</td>
                <td>{{ operation.date }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="history-pagination">
            <Pagination
              :items-count="operationsCount"
              :items-limit="operationsDisplayLimit"
              v-model:page="queryParams.page"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>
