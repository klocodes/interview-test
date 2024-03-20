<script setup>
import {computed, nextTick, onMounted, ref, watch} from "vue";

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: '',
  },

  placeholder: {
    type: String,
    default: null,
  },

  isRequired: {
    type: Boolean,
    default: null,
  },

  isFocused: {
    type: Boolean,
    default: null,
  },

  type: {
    type: String,
    default: 'text',
    validator(value) {
      return ['text', 'number', 'alpha'].includes(value);
    }
  },

  min: {
    type: Number,
    default: null,
  },

  max: {
    type: Number,
    default: null,
  },

  length: {
    type: Number,
    default: null,
  },

  errors: {
    type: Array,
    default: () => [],
  },
})

const focused = ref(props.isFocused !== null ? props.isFocused : false)

const rootContainerClasses = computed(() => {
  return {
    '--focused': focused.value || props.modelValue,
    '--required': props.isRequired,
    '--failed': props.errors.length > 0,
  }
})

const emit = defineEmits([
  'update:modelValue',
  'focus',
  'blur',
])

const differenceHeight = 30;
const handleInput = async (event) => {
  await nextTick();

  const element = event.target;

  if (props.type === 'number') {
    element.value = handleNumber(element.value)
  }

  if (props.type === 'alpha') {
    element.value = handleAlpha(element.value)
  }

  handleHeight(element)

  emit('update:modelValue', element.value);
}

const handleHeight = (element) => {
  element.style.height = 'auto';

  element.parentNode.style.height = `${differenceHeight + element.scrollHeight}px`;
  element.style.height = element.scrollHeight + 'px';
}

const handleNumber = (value) => {
  value = value.replace(/\D/g, '');


  if (props.min !== null && value !== '' && value < props.min) {
    value = props.modelValue
  }

  if (props.max !== null && value !== '' && value > props.max) {
    value = props.modelValue
  }

  return value;
}

const handleAlpha = (value) => {
  if (props.type === 'alpha') {
    value = value.replace(/[^a-zA-Zа-яА-ЯёЁ]/g, '');
  }

  if (props.type !== 'number' && props.max !== null && value.length > props.max) {
    value = value.slice(0, props.max);
  }

  return value;
}

watch(() => props.isFocused, (value) => {
  focused.value = value
})

const handleFocus = (event, value) => {
  if (props.isFocused === null || props.isFocused === value) {
    focused.value = value

    emit(event.type, event)
  } else {
    focused.value = props.isFocused
  }
}
</script>

<template>
  <div class="edit-control__container">
    <div
        :class="rootContainerClasses"
        class="edit-control"
        @focus="handleFocus($event, true)"
        @blur="handleFocus($event, false)"
    >
    <textarea
        :class="{'--focused': focused}"
        :value="props.modelValue"
        @input="handleInput"
        @focus="handleFocus($event, true)"
        @blur="handleFocus($event, false)"
        class="edit-control__input"
        rows="1"
    />
      <div
          v-if="props.placeholder"
          :class="{'--up': focused || props.modelValue}"
          class="edit-control__placeholder"
      >
        {{ props.placeholder }}
      </div>
    </div>

    <div
        v-if="props.errors.length"
        class="edit-control__errors">
      <div
          v-for="error in props.errors"
          class="edit-control__error">
        {{ error.$message }}
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.edit-control {
  position: relative;
  display: inline-flex;
  align-items: flex-end;
  gap: 5px;
  width: 100%;
  min-height: 50px;
  border-bottom: 1px solid $palette-border;
  outline: none;
  transition: border .4s ease;

  &.--focused {
    border-bottom: 2px solid $palette-primary;
  }

  &.--failed {
    border-bottom: 2px solid $palette-error;
  }

  &__input {
    position: absolute;
    bottom: 7px;
    left: 0;
    display: block;
    width: 100%;
    height: 20px;
    min-height: 20px;
    padding: 0;
    border: none;
    resize: none;
    background: transparent;
    margin: 0;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.3;
    z-index: 1;
    overflow: hidden;

    &:focus, &:focus-visible {
      outline: none;
    }
  }

  &.--failed &__input, &.--failed &__placeholder {
    color: $palette-error;
  }

  &__placeholder {
    position: absolute;
    bottom: 7px;
    left: 0;
    display: flex;
    align-items: center;
    gap: 3px;
    width: 100%;
    height: 20px;
    font-size: 16px;
    line-height: 1;
    color: $palette-text-placeholder;
    transition: all .4s ease;

    &.--up {
      top: 0;
      bottom: auto;
      font-size: 12px;
      color: $palette-primary
    }
  }

  &.--required &__placeholder {
    &:before {
      content: '*';
      display: block;
      color: $palette-error;
    }
  }

  &__error {
    font-size: 14px;
    color: $palette-error;

    &s {
      display: grid;
      grid-gap: 10px 0;
      justify-content: end;
      margin: 10px 0 0;
    }
  }
}
</style>
