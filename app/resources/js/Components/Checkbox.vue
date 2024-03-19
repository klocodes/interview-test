<script setup>
defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },

  label: {
    type: String,
    default: null,
  },

  disabled: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['update:modelValue'])
</script>

<template>
  <div
    :class="{'checked': modelValue, '--disabled': disabled}"
    @click="$emit('update:modelValue', modelValue = !modelValue)"
    class="checkbox-control"
  >
    <div v-if="label">
      {{ label }}
    </div>
  </div>
</template>

<style scoped lang="scss">
.checkbox-control {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  cursor: pointer;

  &.--disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
  }

  &:before {
    content: '';
    display: block;
    width: 20px;
    height: 20px;
    border: 1px solid $palette-accent;
    transition: border .4s ease;
  }

  &:after {
    content: '';
    position: absolute;
    top: 6px;
    left: 4px;
    display: block;
    width: 12px;
    height: 12px;
    background-color: $palette-accent;
    opacity: 0;
    transition: opacity .4s ease;
    box-sizing: content-box;
  }

  &.checked {
    &:before {
      border-color: $palette-accent-hover;
      border-width: 2px;
    }

    &:after {
      opacity: 1;
    }
  }
}
</style>
