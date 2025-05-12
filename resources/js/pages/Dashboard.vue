<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { ToastAction, ToastDescription, ToastProvider, ToastRoot, ToastTitle, ToastViewport } from 'reka-ui';
import { ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tasks',
    href: '/dashboard',
  },
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
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
          <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
            <PlaceholderPattern />
          </div>
          <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
            <PlaceholderPattern />
          </div>
          <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
            <PlaceholderPattern />
          </div>
        </div>
        <div class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 rounded-xl border md:min-h-min">
          <PlaceholderPattern />
        </div>
      </div>
    </div>
    <ToastProvider>
      <ToastRoot
        v-model:open="open"
        class="bg-green-100 rounded-lg shadow-sm border border-green-300 p-3 data-[state=open]:animate-slideIn data-[state=closed]:animate-hide data-[swipe=move]:translate-x-[var(--reka-toast-swipe-move-x)] data-[swipe=cancel]:translate-x-0 data-[swipe=cancel]:transition-[transform_200ms_ease-out] data-[swipe=end]:animate-swipeOut"
      >
        <ToastDescription as-child>
          {{ page.props.flash?.success }}
        </ToastDescription>
      </ToastRoot>
      <ToastViewport class="[--viewport-padding:_25px] fixed bottom-0 right-0 flex flex-col p-[var(--viewport-padding)] gap-[10px] w-[390px] max-w-[100vw] m-0 list-none z-[2147483647] outline-none" />
    </ToastProvider>
  </AppLayout>
</template>
