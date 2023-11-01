<template>
  <div class="w-full pt-6">
    <hr class="border-black">
    <div class="w-full rounded-2xl bg-white mt-3 ">
      <Disclosure v-slot="{ open }" :defaultOpen="true">
        <DisclosureButton
            class="flex w-full justify-between rounded-lg  py-2 text-left text-sm font-medium text-black "
        >
          <span class="font-semibold">
            <slot name="title"/>
          </span>
          <ChevronDownIcon
              :class="open ? 'rotate-180 transform' : ''"
              class="h-5 w-5 transition-all ease-in-out duration-300 text-black  "
          />
        </DisclosureButton>
        <DisclosurePanel class="pt-4 pb-2 text-sm text-gray-500">
          <slot name="body"/>
        </DisclosurePanel>
      </Disclosure>
    </div>
  </div>
</template>

<script setup>
import { ChevronDownIcon } from '@heroicons/vue/solid'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import {ref} from "vue";

const tabOpen = ref(true);
</script>
