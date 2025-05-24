<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import { Table } from '@/components/ui/table';
import Toast from '../../components/ui/toast/Toast.vue';
import { useTasksStore } from '@/stores/tasks.store';
import { storeToRefs } from 'pinia';
import { priorityOptions, statusOptions } from '@/constants/options';
import { Select } from '@/components/ui/input';
import DateInput from '@/components/ui/input/DateInput.vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tasks',
    href: '/dashboard',
  },
];

const columns = [
  { key: 'title', label: 'Title' },
  { key: 'description', label: 'Description' },
  { key: 'formatted_status', label: 'Status' },
  { key: 'formatted_priority', label: 'Priority' },
  { key: 'formatted_due_date', label: 'Due date' },
  { key: 'formatted_assigned_to', label: 'Assigned to' },
];

const page = usePage();
const { fetch, resetFilters, deleteTask } = useTasksStore();
const { tasks, meta, sort, filter } = storeToRefs(useTasksStore());

const open = ref(false);

function createTask() {
  router.visit('/tasks/create');
}

async function handlePageChange(page: number) {
  await fetch(page);
}

async function handleSortChange(_sort: object[]) {
  sort.value = _sort;

  await fetch();
}

function handleEdit(item: object) {
  router.visit(`/tasks/${item.id}/edit`);
}

async function handleDelete(item: object) {
  const confirmed = window.confirm('Are you sure you want to delete this task?');

  if (confirmed) {
    await deleteTask(item.id);
    await fetch();
  }
}

watch(
  () => page.props?.flash?.success,
  (value) => {
    if (value) {
      open.value = true;
    }
  },
  { immediate: true },
);

watch(
  () => filter.value,
  async () => {
    await fetch();
  },
  { deep: true }
);

onMounted(async () => {
  sort.value = [];

  await fetch();
});
</script>

<template>
  <Head title="Taskly" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <Button class="mb-4 ml-auto flex" @click="createTask"> Create task </Button>
      <div class="flex gap-4 items-center mb-4">
        <span>Filter by</span>
        <Select
          v-model="filter.status"
          :options="statusOptions"
          label="Status"
          name="status"
        />
        <Select
          v-model="filter.priority"
          :options="priorityOptions"
          label="Priority"
          name="priority"
        />
        <div class="flex items-center gap-2">
          <span>From</span>
          <DateInput v-model="filter.from_date" />
          <span>to</span>
          <DateInput v-model="filter.to_date" />
        </div>
        <Button variant="outline" @click="resetFilters">
          Clear filters
        </Button>
      </div>
      <Table
        v-if="tasks.length"
        :columns="columns"
        :data="tasks"
        :striped="true"
        :hover="true"
        :meta="meta"
        :has-actions="true"
        @on-page-change="handlePageChange"
        @on-sort-change="handleSortChange"
        @on-edit="handleEdit"
        @on-delete="handleDelete"
      />
    </div>
    <Toast v-model:open="open" :message="page.props.flash?.success" />
  </AppLayout>
</template>
