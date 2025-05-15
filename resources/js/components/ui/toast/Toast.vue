<script setup lang="ts">
import { ToastDescription, ToastProvider, ToastRoot, ToastViewport } from 'reka-ui';
import { computed } from 'vue';

interface Props {
  open: boolean;
  message?: string;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  'update:open': [value: boolean]
}>();

const isOpen = computed({
  get() {
    return props.open;
  },
  set(value: boolean) {
    emit('update:open', value);
  },
});

</script>

<template>
  <ToastProvider>
    <ToastRoot
      v-model:open="isOpen"
      class="bg-green-100 rounded-lg shadow-sm border border-green-300 p-3 data-[state=open]:animate-slideIn data-[state=closed]:animate-hide data-[swipe=move]:translate-x-[var(--reka-toast-swipe-move-x)] data-[swipe=cancel]:translate-x-0 data-[swipe=cancel]:transition-[transform_200ms_ease-out] data-[swipe=end]:animate-swipeOut"
    >
      <ToastDescription as-child>
        {{ message }}
      </ToastDescription>
    </ToastRoot>
    <ToastViewport class="[--viewport-padding:_25px] fixed bottom-0 right-0 flex flex-col p-[var(--viewport-padding)] gap-[10px] w-[390px] max-w-[100vw] m-0 list-none z-[2147483647] outline-none" />
  </ToastProvider>
</template>

<style scoped>

</style>
