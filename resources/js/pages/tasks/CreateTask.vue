<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { onMounted, ref } from 'vue';
import { Input, Select, Textarea } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import DateInput from '@/components/ui/input/DateInput.vue';
import { useUsersStore } from '@/stores/users.store';
import { storeToRefs } from 'pinia';
import { statusOptions, priorityOptions } from '@/constants/options';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tasks',
    href: '/dashboard',
  },
];

const { fetchUsers } = useUsersStore();
const { users: usersList } = storeToRefs(useUsersStore());

const dueDate = ref(null);

// Form state
const form = useForm({
  title: '',
  description: '',
  status: '',
  priority: '',
  due_date: '',
  assigned_to: '',
});

// Form handling
const handleSubmit = () => {
  if (dueDate.value) {
    const date = new Date(dueDate.value.year, dueDate.value.month - 1, dueDate.value.day);

    form.due_date = date.toISOString().split('T')[0];
  }

  form.post('/tasks', {
    onSuccess: () => {
      form.reset();
    },
  });
};

onMounted(async () => {
  await fetchUsers();
})
</script>

<template>
  <Head title="Taskly" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
      <form @submit.prevent="handleSubmit" class="flex w-full flex-1 flex-col gap-4 rounded-xl bg-white p-4 shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800">Create Task</h2>

        <!-- Title -->
        <div class="flex flex-col gap-2">
          <Label for="title">Title *</Label>
          <Input v-model="form.title" label="Title" placeholder="Enter task title" name="title" />
          <InputError v-if="form.errors.title" :message="form.errors.title" />
        </div>

        <!-- Description -->
        <div class="flex flex-col gap-2">
          <Label for="description"> Description </Label>
          <Textarea v-model="form.description" label="Description" placeholder="Enter task details" name="description" rows="4" />
          <InputError v-if="form.errors.description" :message="form.errors.description" />
        </div>

        <!-- Status -->
        <div class="flex flex-col gap-2">
          <Label for="status"> Status * </Label>
          <Select v-model="form.status" :options="statusOptions" label="Select the status" name="status" />
          <InputError v-if="form.errors.status" :message="form.errors.status" />
        </div>

        <!-- Priority -->
        <div class="flex flex-col gap-2">
          <Label for="priority"> Priority * </Label>
          <Select v-model="form.priority" :options="priorityOptions" label="Select the priority" name="priority" />
          <InputError v-if="form.errors.priority" :message="form.errors.priority" />
        </div>

        <!-- Due Date -->
        <div class="flex flex-col gap-2">
          <DateInput
            label="Due date"
            v-model="dueDate"
          />
          <InputError v-if="form.errors.due_date" :message="form.errors.due_date" />
        </div>

        <!-- Assigned To -->
        <div
          v-if="usersList"
          class="flex flex-col gap-2"
        >
          <Label for="assigned_to"> Assign to </Label>
          <Select v-model="form.assigned_to" :options="usersList" label="Select the user" name="assigned_to" />
          <InputError v-if="form.errors.assigned_to" :message="form.errors.assigned_to" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
          <Button type="submit" :loading="form.processing"> Create task </Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
