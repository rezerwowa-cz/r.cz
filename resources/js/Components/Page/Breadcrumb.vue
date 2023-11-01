<script setup>
import { ChevronRightIcon } from '@heroicons/vue/solid'

defineProps({
  pages: {
    type: Object,
  },
});
</script>

<template>
  <nav class="justify-between py-3 text-black sm:flex  " aria-label="Breadcrumb">
    <ol class="inline-flex items-center mb-3 space-x-1 md:space-x-3 sm:mb-0">
      <li v-for="(page, index) in pages" :class="[page.current ? 'font-bold' : '']">
        <div class="flex items-center">
          <ChevronRightIcon v-if="index !== 0"
              class="h-5 w-5 text-black mr-3"
              aria-hidden="true"
          />
          <span>{{ page.title }}</span>
        </div>
      </li>
    </ol>
  </nav>
</template>
