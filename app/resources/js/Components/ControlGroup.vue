<template>
  <div class="control-group">
    <slot/>
  </div>
</template>

<style lang="scss">
  .control-group {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
</style>
