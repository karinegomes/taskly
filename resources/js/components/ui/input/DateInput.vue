<script setup lang="ts">
import { DateFieldInput, DateFieldRoot, DateValue } from 'reka-ui';
import { Label } from '@/components/ui/label';
import { computed } from 'vue';

const props = defineProps<{
  label?: string;
  modelValue: DateValue|null;
}>();

const emits = defineEmits(['update:modelValue']);

const date = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emits('update:modelValue', value);
  }
});
</script>

<template>
  <div>
    <Label
      v-if="props.label"
      for="birthday"
    >
      {{ label }}
    </Label>
    <DateFieldRoot
      id="birthday"
      v-slot="{ segments }"
      class="w-full flex select-none bg-white items-center rounded-lg text-sm text-center text-green10 border border-input p-3 data-[invalid]:border-red-500"
      v-model="date"
    >
      <template
        v-for="item in segments"
        :key="item.part"
      >
        <DateFieldInput
          v-if="item.part === 'literal'"
          :part="item.part"
        >
          {{ item.value }}
        </DateFieldInput>
        <DateFieldInput
          v-else
          :part="item.part"
          class="rounded focus:outline-none focus:shadow-[0_0_0_2px] focus:shadow-black data-[placeholder]:text-green9"
        >
          {{ item.value }}
        </DateFieldInput>
      </template>
    </DateFieldRoot>
  </div>
</template>
