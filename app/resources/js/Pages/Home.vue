<script setup>
import Balance from "~/Features/Balances/Current.vue";
import LatestOperations from "~/Features/Operations/Latest.vue";

</script>

<template>
  <div class="home">
    <div class="container">
      <div class="card">
        <div class="card-body">
          <div class="home-balance">
            <Balance/>
          </div>

          <LatestOperations/>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.home {
  padding: 50px 0;

  &-balance {
    margin: 0 0 50px;
  }
}
</style>
