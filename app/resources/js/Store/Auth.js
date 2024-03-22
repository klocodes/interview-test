import {defineStore} from "pinia"
import {ref} from "vue"
import {useToast} from "vue-toastification"
import serverErrorHandler from "~/utils/serverErrorHandler"

const toast = useToast()

const LOGIN_URL = '/login'
const LOGIN_PAGE_URL = '/sign-in'
const LOGOUT_URL = '/logout'
const REDIRECT_URL = '/'

export const useAuthStore = defineStore('auth', () => {
  const user = ref({
    id: null,
    name: null,
    email: null,
  })

  const fetch = async () => {
    try {
      const {data} = await axios.get('/user')

      user.value = data
    } catch (error) {
      serverErrorHandler(toast, error)
    }
  }

  const login = async (payload) => {
    try {
      const {data} = await axios.post(LOGIN_URL, payload)

      user.value = data.user

      window.location.href = REDIRECT_URL
    } catch (error) {
      serverErrorHandler(toast, error)
    }
  }

  const logout = async () => {
    try {
      await axios.post(LOGOUT_URL)

      window.location.href = LOGIN_PAGE_URL
    } catch (error) {
      serverErrorHandler(toast, error)
    }
  }

  return {
    user, login, logout, fetch
  }
})
