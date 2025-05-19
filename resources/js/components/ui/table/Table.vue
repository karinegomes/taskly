<script setup lang="ts">
import Pagination from '@/components/ui/Pagination.vue';

interface Column {
  key: string;
  label: string;
}

interface TableProps {
  columns: Column[];
  data: any[];
  striped?: boolean;
  hover?: boolean;
  meta?: any;
}

defineProps<TableProps>();

const emits = defineEmits(['onPageChange']);

const onPageChange = (page: number) => {
  emits('onPageChange', page);
}
</script>

<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-left text-sm">
      <thead class="bg-gray-50 text-xs uppercase text-gray-700">
      <tr>
        <th
          v-for="column in columns"
          :key="column.key"
          scope="col"
          class="px-6 py-3"
        >
          {{ column.label }}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
        v-for="(row, index) in data"
        :key="index"
        :class="[
            'bg-white border-b',
            striped && index % 2 === 0 ? 'bg-gray-50' : '',
            hover ? 'hover:bg-gray-100' : '',
          ]"
      >
        <td
          v-for="column in columns"
          :key="column.key"
          class="px-6 py-4"
        >
          {{ row[column.key] }}
        </td>
      </tr>
      </tbody>
    </table>
  </div>
  <Pagination
    v-if="meta"
    :meta="meta"
    @onPageChange="onPageChange"
  />

</template>
