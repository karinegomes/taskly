<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { Input, Textarea, Select } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tasks',
    href: '/dashboard',
  },
];

const page = usePage();
// Form state
const form = useForm({
  title: '',
  description: '',
  status: '',
  priority: '',
  due_date: '',
  assigned_to: '',
});

// Options for select fields
const statusOptions = [
  { label: 'Pending', value: 'pending' },
  { label: 'In Progress', value: 'in_progress' },
  { label: 'Completed', value: 'completed' },
]

const priorityOptions = [
  { label: 'Low', value: 'low' },
  { label: 'Medium', value: 'medium' },
  { label: 'High', value: 'high' },
  { label: 'Urgent', value: 'urgent' },
]

// Mocked user list – replace with real data from props or API
const userOptions = [
  { label: 'Alice', value: 1 },
  { label: 'Bob', value: 2 },
  { label: 'Charlie', value: 3 },
]

// Form handling
const handleSubmit = () => {
  form.post('/tasks', {
    onSuccess: () => {
      form.reset()
    },
  });
}
</script>

<template>
  <Head title="Taskly" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
      <form
        @submit.prevent="handleSubmit"
        class="w-full p-4 bg-white rounded-xl shadow-lg flex flex-1 flex-col gap-4"
      >
        <h2 class="text-xl font-semibold text-gray-800">Create Task</h2>

        <!-- Title -->
        <div class="flex flex-col gap-2">
          <Label for="title">Title *</Label>
          <Input
            v-model="form.title"
            label="Title"
            placeholder="Enter task title"
            name="title"
          />
          <InputError
            v-if="form.errors.title"
            :message="form.errors.title"
          />
        </div>

        <!-- Description -->
        <div class="flex flex-col gap-2">
          <Label for="description">
            Description
          </Label>
          <Textarea
            v-model="form.description"
            label="Description"
            placeholder="Enter task details"
            name="description"
            rows="4"
          />
          <InputError
            v-if="form.errors.description"
            :message="form.errors.description"
          />
        </div>

        <!-- Status -->
        <div class="flex flex-col gap-2">
          <Label for="status">
            Status *
          </Label>
          <Select
            v-model="form.status"
            :options="statusOptions"
            label="Select the status"
            name="status"
          />
          <InputError
            v-if="form.errors.status"
            :message="form.errors.status"
          />
        </div>

        <!-- Priority -->
        <div class="flex flex-col gap-2">
          <Label for="priority">
            Priority *
          </Label>
          <Select
            v-model="form.priority"
            :options="priorityOptions"
            label="Select the priority"
            name="priority"
          />
          <InputError
            v-if="form.errors.priority"
            :message="form.errors.priority"
          />
        </div>

        <!-- Due Date -->
        <div class="flex flex-col gap-2">
          <Label for="due_date">
            Due date
          </Label>
          <Input
            v-model="form.due_date"
            label="Due date"
            placeholder="Enter due date"
            name="due_date"
            :error="form.errors.due_date"
          />
          <InputError
            v-if="form.errors.due_date"
            :message="form.errors.due_date"
          />
        </div>

        <!-- Assigned To -->
        <div class="flex flex-col gap-2">
          <Label for="assigned_to">
            Assign to
          </Label>
          <Select
            v-model="form.assigned_to"
            :options="userOptions"
            label="Select the user"
            name="assigned_to"
          />
          <InputError
            v-if="form.errors.assigned_to"
            :message="form.errors.assigned_to"
          />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
          <Button type="submit" :loading="form.processing">
            Create task
          </Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped></style>
