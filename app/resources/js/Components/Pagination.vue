<script setup>
import {computed, ref} from "vue";

const props = defineProps({
  itemsCount: {
    type: Number,
    required: true,
  },

  itemsLimit: {
    type: Number,
    required: true,
  }
});

const currentPage = ref(1)

const totalPages = computed(() => Math.ceil(props.itemsCount / props.itemsLimit))

const emit = defineEmits(['update:page'])

const updatePage = (page = 1) => {
  if (page < 1 || page > totalPages) {
    return
  }

  currentPage.value = page

  emit('update:page', page)
}
</script>

<template>
  <nav aria-label="Pagination">
    <ul class="pagination justify-content-start">
      <li  v-if="currentPage > 1" class="page-item">
        <a class="page-link" @click.prevent="updatePage(currentPage - 1)">Назад</a>
      </li>
      <li v-else class="page-item disabled">
        <span class="page-link">Назад</span>
      </li>

      <template v-for="page in totalPages" :key="`pageItem-${page}`">
        <li v-if="page !== currentPage" class="page-item">
          <a class="page-link" @click.prevent="updatePage(page)">{{ page }}</a>
        </li>
        <li v-else class="page-item active">
          <span class="page-link">{{ page }}</span>
        </li>
      </template>

      <li v-if="currentPage < totalPages"  class="page-item" >
        <a class="page-link" @click.prevent="updatePage(currentPage + 1)">Вперед</a>
      </li>
      <li v-else class="page-item disabled">
        <span class="page-link">Вперед</span>
      </li>
    </ul>
  </nav>
</template>

<style scoped lang="scss">
.page-link {
  cursor: pointer;
}
</style>
