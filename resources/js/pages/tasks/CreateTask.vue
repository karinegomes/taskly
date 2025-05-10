<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { Input, Textarea, Select } from '@/components/ui/input';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tasks',
    href: '/dashboard',
  },
];

// Form state
const form = ref({
  title: '',
  description: '',
  status: '',
  priority: '',
  due_date: '',
  assigned_to: '',
})

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
const errors = ref({})
const isSubmitting = ref(false)

const handleSubmit = async () => {
  isSubmitting.value = true
  errors.value = {}

  try {
    // Replace with real POST logic (e.g., Inertia.post or axios)
    console.log('Submitting', form.value)

    // Fake delay
    await new Promise((r) => setTimeout(r, 1000))

    // Reset form on success
    form.value = {
      title: '',
      description: '',
      status: '',
      priority: '',
      due_date: '',
      assigned_to: '',
    }
  } catch (e) {
    // Example error structure – adapt to your backend
    errors.value = e.response?.data?.errors || {}
  } finally {
    isSubmitting.value = false
  }
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
        <Input
          v-model="form.title"
          label="Title"
          placeholder="Enter task title"
          :error="errors.title"
          required
        />

        <!-- Description -->
        <Textarea
          v-model="form.description"
          label="Description"
          placeholder="Enter task details"
          :error="errors.description"
          rows="4"
        />

        <Select
          v-model="form.status"
          :options="statusOptions"
          label="Status"
        />

        <pre>{{ form.status }}</pre>

        <!-- Status -->
        <select
          v-model="form.status"
          label="Status"
          :options="statusOptions"
          :error="errors.status"
          required
        />

        <!-- Priority -->
        <r-select
          v-model="form.priority"
          label="Priority"
          :options="priorityOptions"
          :error="errors.priority"
          required
        />

        <!-- Due Date -->
        <r-input
          v-model="form.due_date"
          type="date"
          label="Due Date"
          :error="errors.due_date"
        />

        <!-- Assigned To -->
        <r-select
          v-model="form.assigned_to"
          label="Assign To"
          :options="userOptions"
          :error="errors.assigned_to"
          placeholder="Select a user"
        />

        <!-- Submit Button -->
        <div class="pt-4">
          <r-button type="submit" variant="primary" :loading="isSubmitting">
            Create Task
          </r-button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped></style>
