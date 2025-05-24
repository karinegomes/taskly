<script setup lang="ts">
import Pagination from '@/components/ui/Pagination.vue';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';

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
  hasActions?: boolean;
}

defineProps<TableProps>();

const emits = defineEmits(['onPageChange', 'onSortChange', 'onEdit', 'onDelete']);

const sort = ref<{ key: string; direction: 'asc' | 'desc' }[]>([]);

const toggleSort = (columnKey: string) => {
  const idx = sort.value.findIndex(s => s.key === columnKey);
  if (idx === -1) {
    sort.value.push({ key: columnKey, direction: 'asc' });
  } else if (sort.value[idx].direction === 'asc') {
    sort.value[idx].direction = 'desc';
  } else {
    sort.value.splice(idx, 1);
  }
  emits('onSortChange', [...sort.value]);
};

const sortIndicator = (columnKey: string) => {
  const s = sort.value.find(s => s.key === columnKey);
  if (!s) return '';
  return s.direction === 'asc' ? '▲' : '▼';
};

const onPageChange = (page: number) => {
  emits('onPageChange', page);
}

const onEdit = (item: object) => {
  emits('onEdit', item);
}

const onDelete = (item: object) => {
  emits('onDelete', item);
};
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
          class="px-6 py-3 cursor-pointer select-none group"
          @click="toggleSort(column.key)"
        >
          <span>{{ column.label }}</span>
          <span class="ml-1 text-xs align-middle group-hover:text-blue-500">{{ sortIndicator(column.key) }}</span>
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
        <td v-if="hasActions" class="flex gap-4 px-6 py-4 justify-end">
          <Button variant="secondary" @click="onEdit(row)">
            Edit
          </Button>
          <Button variant="destructive" @click="onDelete(row)">
            Delete
          </Button>
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
