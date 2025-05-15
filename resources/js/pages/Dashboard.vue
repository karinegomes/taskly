<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Table } from '@/components/ui/table';
import Toast from '../components/ui/toast/Toast.vue';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tasks',
    href: '/dashboard',
  },
];

const columns = [
  { key: 'id', label: 'ID' },
  { key: 'name', label: 'Name' },
  { key: 'email', label: 'Email' },
  { key: 'status', label: 'Status' }
];

const data = [
  { id: 1, name: 'John Doe', email: 'john@example.com', status: 'Active' },
  { id: 2, name: 'Jane Smith', email: 'jane@example.com', status: 'Inactive' },
  // ... more data
];


const page = usePage();
const open = ref(false);

function createTask() {
  router.visit('/tasks/create');
}

watch(
  () => page.props?.flash?.success,
  (value) => {
    if (value) {
      open.value = true;
    }
  },
  { immediate: true }
);
</script>

<template>
  <Head title="Taskly" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <Button class="mb-4 ml-auto flex" @click="createTask">
        Create task
      </Button>
      <Table
        :columns="columns"
        :data="data"
        :striped="true"
        :hover="true"
      />
    </div>

    <Toast
      v-model:open="open"
      :message="page.props.flash?.success"
    />
  </AppLayout>
</template>
