import {defineStore} from "pinia";
import {ref} from "vue";
import serverErrorHandler from "~/utils/serverErrorHandler"
import {useToast} from "vue-toastification";

const toast = useToast()

const FETCH_LATEST_OPERATIONS_URL = '/operations/latest'
const FETCH_OPERATIONS_HISTORY_URL = '/operations/history'

const HISTORY_OPERATIONS_DISPLAY_LIMIT = 5;

export const useOperationsStore = defineStore('operations', () => {
  const latestOperations = ref(null);

  const operationsCount = ref(0);
  const operations = ref(null);
  const operationsDisplayLimit = ref(HISTORY_OPERATIONS_DISPLAY_LIMIT);

  const fetchLatestOperations = async () => {
    try {
      const {data} = await axios.get(FETCH_LATEST_OPERATIONS_URL);

      latestOperations.value = data.operations;
    } catch (e) {
      serverErrorHandler(toast, e)
    }
  }

  const fetchOperationsHistory= async (params) => {
    try {
      const {data} = await axios.get(FETCH_OPERATIONS_HISTORY_URL, {
        params: {
          limit: operationsDisplayLimit.value,
          page: params.page,
          search_string: params.search_string,
          sort_field: params.sort_field,
          sort_direction: params.sort_direction
        }
      });

      operationsCount.value = data.count;
      operations.value = data.operations;
    } catch (e) {
      serverErrorHandler(toast, e)
    }
  }

  return {
    latestOperations,
    operations,
    operationsCount,
    operationsDisplayLimit,

    fetchLatestOperations,
    fetchOperationsHistory
  }
});
