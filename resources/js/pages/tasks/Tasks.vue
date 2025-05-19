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

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tasks',
    href: '/dashboard',
  },
];

const columns = [
  { key: 'title', label: 'Title' },
  { key: 'description', label: 'Description' },
  { key: 'status', label: 'Status' },
  { key: 'priority', label: 'Priority' },
  { key: 'due_date', label: 'Due date' },
  { key: 'assigned_to', label: 'Assigned to' },
];

const page = usePage();
const { fetch } = useTasksStore();
const { tasks, meta } = storeToRefs(useTasksStore());

const open = ref(false);

function createTask() {
  router.visit('/tasks/create');
}

function handlePageChange(page: number) {
  fetch(page);
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

onMounted(async () => {
  await fetch();
});
</script>

<template>
  <Head title="Taskly" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <Button class="mb-4 ml-auto flex" @click="createTask"> Create task </Button>
      <Table
        v-if="tasks.length"
        :columns="columns"
        :data="tasks"
        :striped="true"
        :hover="true"
        :meta="meta"
        @on-page-change="handlePageChange"
      />
    </div>
    <Toast v-model:open="open" :message="page.props.flash?.success" />
  </AppLayout>
</template>
