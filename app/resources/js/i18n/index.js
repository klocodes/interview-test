import {createI18n} from 'vue-i18n'
import ru from './ru.json'

export const i18n = createI18n({
    locale: 'ru', // устанавливаем русский язык по умолчанию
    messages: ru, // устанавливаем в качестве сообщений объект с переводами
})
