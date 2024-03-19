<script setup>
const props = defineProps({
  action: {
    type: String,
    default: 'create',
  },

  disabled: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <div
      :class="[`--${props.action}`, {'btn-disabled': props.disabled}]"
      class="btn btn-primary"
  >
    <slot name="title"/>
  </div>
</template>
