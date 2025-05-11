<script setup lang="ts">
import { Icon } from '@iconify/vue';
import {
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectItemIndicator,
  SelectItemText,
  SelectPortal,
  SelectRoot,
  SelectScrollDownButton,
  SelectScrollUpButton,
  SelectTrigger,
  SelectValue,
  SelectViewport,
} from 'reka-ui'
import { useVModel } from '@vueuse/core';

interface Props {
  modelValue: string|number;
  options: object[];
  label: string;
}

const props = defineProps<Props>();

const emits = defineEmits<{
  (e: 'update:modelValue', payload: string | number): void
}>();

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true
});
</script>

<template>
  <SelectRoot v-model="modelValue">
    <SelectTrigger
      class="inline-flex min-w-[160px] items-center justify-between rounded-md px-3 py-3 text-sm leading-none gap-[5px] bg-white text-grass11 hover:bg-stone-50 border  border-input shadow-xs data-[placeholder]:text-green9 outline-none"
      aria-label="Customise options"
    >
      <SelectValue :placeholder="$props.label" />
      <Icon
        icon="radix-icons:chevron-down"
        class="h-3.5 w-3.5"
      />
    </SelectTrigger>

    <SelectPortal>
      <SelectContent
        class="min-w-[160px] bg-white rounded-md border border-input shadow-xs will-change-[opacity,transform] data-[side=top]:animate-slideDownAndFade data-[side=right]:animate-slideLeftAndFade data-[side=bottom]:animate-slideUpAndFade data-[side=left]:animate-slideRightAndFade z-[100]"
        :side-offset="5"
      >
        <SelectScrollUpButton class="flex items-center justify-center h-[25px] bg-white text-violet11 cursor-default">
          <Icon icon="radix-icons:chevron-up" />
        </SelectScrollUpButton>

        <SelectViewport class="p-[5px]">
          <SelectGroup>
            <SelectItem
              v-for="(option, index) in $props.options"
              :key="index"
              class="text-sm leading-none text-grass11 rounded-[3px] flex items-center h-[25px] pr-[35px] pl-[25px] relative select-none data-[disabled]:text-mauve8 data-[disabled]:pointer-events-none data-[highlighted]:outline-none data-[highlighted]:bg-green9 data-[highlighted]:text-green1"
              :value="option.value"
            >
              <SelectItemIndicator class="absolute left-0 w-[25px] inline-flex items-center justify-center">
                <Icon icon="radix-icons:check" />
              </SelectItemIndicator>
              <SelectItemText>
                {{ option.label }}
              </SelectItemText>
            </SelectItem>
          </SelectGroup>
        </SelectViewport>

        <SelectScrollDownButton class="flex items-center justify-center h-[25px] bg-white text-violet11 cursor-default">
          <Icon icon="radix-icons:chevron-down" />
        </SelectScrollDownButton>
      </SelectContent>
    </SelectPortal>
  </SelectRoot>
</template>

<style scoped>

</style>
