<script setup lang="ts">
defineProps<{
  meta: any,
  links: any[]
}>();

const emits = defineEmits(['onPageChange']);

function onPageChange(page: number) {
  emits('onPageChange', page);
}
</script>

<template>
  <nav
    v-if="meta && meta.last_page > 1"
    class="flex items-center justify-center mt-4 space-x-1"
    aria-label="Pagination"
  >
    <button
      v-for="(link, i) in meta.links"
      :key="i"
      v-html="link.label"
      :disabled="!link.url"
      @click="link.url ? onPageChange(link.label === '...' ? null : +link.label || (link.label.includes('Next') ? meta.current_page + 1 : meta.current_page - 1)) : null"
      :class="[
        'px-3 py-1 rounded border',
        link.active ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-blue-100',
        !link.url ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
      ]"
    />
  </nav>
</template>
