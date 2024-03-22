import {defineStore} from "pinia";
import {ref} from "vue";
import serverErrorHandler from "~/utils/serverErrorHandler"
import {useToast} from "vue-toastification";

const toast = useToast()

const FETCH_CURRENT_BALANCE_URL = '/balance'

export const useBalanceStore = defineStore('balance', () => {
  const balance = ref(null);

  const fetchCurrentBalance = async () => {
    try {
      const {data} = await axios.get(FETCH_CURRENT_BALANCE_URL);

      balance.value = data.balance;
    } catch (e) {
      serverErrorHandler(toast, e)
    }
  }

  return {
    balance,
    fetchCurrentBalance
  }
});
