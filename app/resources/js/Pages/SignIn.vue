<script setup>
import {reactive, onBeforeMount} from "vue";
import {useVuelidate} from "@vuelidate/core";
import {useToast} from "vue-toastification";

import {required, email} from "~/utils/i18nValidators";

import {useAuthStore} from "~/Store/Auth";

import ControlGroup from "~/Components/ControlGroup.vue";
import EditControl from "~/Components/EditControl.vue";
import Button from "../Components/Button.vue";
import Checkbox from "~/Components/Checkbox.vue";
import PasswordControl from "~/Components/PasswordControl.vue";

const toast = useToast()

const authStore = useAuthStore()

const credentials = reactive({
  email: null,
  password: null,
  remember: false,
})
const rules = {
  email: {required, email},
  password: {required},
}
const v$ = useVuelidate(rules, credentials)

const login = async () => {
  if (!await v$.value.$validate()) {
    toast.error('Проверьте правильность заполнения полей')

    return
  }

  await authStore.login(credentials)
}

onBeforeMount(() => {
  if (authStore.user !== null) {
    location.href = '/'
  }
})
</script>

<template>
  <div class="sign-in">
    <div class="sign-in__container">
      <div class="sign-in__header">
        <h1 class="sign-in__title">Вход</h1>
      </div>

      <div class="sign-in__body">
        <ControlGroup>
          <EditControl
              v-model="credentials.email"
              :is-required="true"
              :errors="v$.email.$errors"
              @input="v$.email.$touch()"
              placeholder="Введите email"
          />

          <PasswordControl
              v-model="credentials.password"
              :is-required="true"
              :errors="v$.password.$errors"
              @input="v$.password.$touch()"
              placeholder="Введите пароль"
          />

          <Checkbox
              v-model="credentials.remember"
              label="Запомнить меня"
              class="sign-in__remember"
          />
        </ControlGroup>

        <div class="sign-in__footer">
          <Button class="sign-in__button" @click="login">
            <template #title>
              Войти
            </template>
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.sign-in {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;

  &__container {
    max-width: 400px;
    width: 100%;
    padding: 30px;
    border-radius: 10px;
    background-color: #fff;
  }

  &__header {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
  }

  &__title {
    font-size: 24px;
    font-weight: 500;
  }

  &__footer {
    display: flex;
    align-items: center;
    margin-top: 20px;
  }

  &__button {
    margin: 20px 0 0;
  }

  &__remember {
    margin: 20px 0 0;
  }
}
</style>
