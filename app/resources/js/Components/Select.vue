<script setup>
import {defineEmits, computed, ref, onMounted} from "vue";
import ArrowDown from "~/Icons/ArrowDown.vue";
import Close from "~/Icons/Close.vue";

const props = defineProps({
  items: {
    type: Array,
    default: [],
  },

  isRequired: {
    type: Boolean,
    default: false,
  },

  placeholder: {
    type: String,
    default: null,
  },

  modelValue: {
    type: [String, Number],
    default: null,
  },

  errors: {
    type: Array,
    default: () => [],
  },
})

const isActive = ref(false);

const selectedItem = computed(() => {
  return props.items.find(item => item.value === props.modelValue);
})

const rootContainerClasses = computed(() => {
  return {
    '--active': isActive.value,
    '--required': props.isRequired,
    '--failed': props.errors.length > 0,
    '--selected': props.modelValue !== null,
  }
})

defineEmits(['update:modelValue'])

let focusTimeout = null;

const handleActivity = () => {
  clearTimeout(focusTimeout);

  isActive.value = !isActive.value;
}

const handleFocus = () => {
  clearTimeout(focusTimeout);

  focusTimeout = setTimeout(() => {
    isActive.value = true;
  }, 50);
}

const handleBlur = () => {
  isActive.value = false;
}

onMounted(() => {
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.select')) {
      isActive.value = false;
    }
  })
})
</script>

<template>
  <div class="select-container">
    <div
        :class="rootContainerClasses"
        :tabindex="0"
        @focus="handleFocus"
        @blur="handleBlur"
        class="select"
    >
      <div
          class="select__header"
          @click="handleActivity"
      >
        <div
            :class="{'--up': props.modelValue !== null}"
            class="select__placeholder"
        >
          {{ props.placeholder ?? 'Выберите значение' }}
        </div>

        <template v-if="selectedItem">
          {{ selectedItem.title }}
        </template>

        <div class="select__icons">
          <Close
              v-if="props.modelValue !== null"
              class="select__close"
              @click.stop="$emit('update:modelValue', null)"
          />

          <ArrowDown
              class="select__arrow"
          />
        </div>
      </div>

      <div class="select__list">
        <template
            v-for="item in props.items"
            :key="item.value"
        >
          <div
              v-if="item.value !== props.modelValue"
              @click="$emit('update:modelValue', item.value)"
              class="select__item"
          >
            {{ item.title }}
          </div>
        </template>
      </div>
    </div>

    <div
        v-if="props.errors.length"
        class="select-errors">
      <div
          v-for="error in props.errors"
          class="select-error">
        {{ error.$message }}
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.select {
  position: relative;
  display: inline-flex;
  align-items: center;
  width: 100%;
  height: 50px;
  overflow: hidden;
  padding: 10px 0 0;
  border-bottom: 1px solid $palette-border;
  transition: all .4s ease;
  background-color: $palette-box;

  &.--active, &.--selected {
    overflow: initial;
    border-bottom: 2px solid $palette-accent;
  }

  &.--failed {
    overflow: initial;
    border-bottom: 2px solid $palette-error;
  }

  &__header {
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 10px;
    width: 100%;
    height: 100%;
    cursor: pointer;
  }

  &__list {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    height: 0;
    overflow: hidden;
    background-color: $palette-box;
    border-radius: 0 0 5px 5px;
    margin: 2px 0 0;
    box-shadow: 1px 5px 10px $palette-shadow;
    z-index: 1;
    transition: all .4s ease;
  }

  &.--active &__list {
    height: auto;
  }

  &__item {
    padding: 20px 10px;
    border-bottom: 1px solid $palette-border;
    cursor: pointer;
    transition: background-color .4s ease;

    &:hover {
      background-color: transparentize($palette-primary, .95);
    }
  }

  &__placeholder {
    display: flex;
    gap: 3px;
    color: $palette-text-placeholder;

    &.--up {
      position: absolute;
      top: 0;
      left: 0;
      font-size: 12px;
      color: $palette-accent
    }
  }

  &.--failed &__header, &.--failed &__placeholder {
    color: $palette-error;
  }

  &.--required &__placeholder {
    &:before {
      content: '*';
      display: block;
      color: $palette-error;
    }
  }

  &__icons {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  &__arrow {
    width: 24px;
    height: 24px;
    transition: all .4s ease;
  }

  &__close {
    margin: 3px 0 0;
  }

  &.--active &__arrow {
    transform: rotate(180deg);
  }

  &-error {
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
