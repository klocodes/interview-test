import * as validators from '@vuelidate/validators'
import {i18n} from '~/i18n'

const {createI18nMessage} = validators

const getLocalizedMessage = (key, params) => {
    let message = i18n.global.t(key, params);

    if (params && params.property) {
        const propertyTranslation = i18n.global.t(`validations.properties.${params.property}`);
        message = message.replace(params.property, propertyTranslation);
    }

    return message;
};

const withI18nMessage = createI18nMessage({ t: getLocalizedMessage })

// wrap each validator.
export const required = withI18nMessage(validators.required)

export const email = withI18nMessage(validators.email)

export const minLength = withI18nMessage(validators.minLength)
