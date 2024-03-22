<script setup>
const props = defineProps({
  href: {
    type: String,
    default: null,
  },

  disabled: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['click'])

const click = () => {
  if (props.disabled) {
    return
  }

  if (props.href !== null) {
    window.location.href = props.href
  }

  emit('click')
}
</script>

<template>
  <div
    :class="[`--${props.action}`, {'btn-disabled': props.disabled}]"
    class="btn btn-primary"
    @click="click"
  >
    <slot></slot>
  </div>
</template>
