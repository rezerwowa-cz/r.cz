<script setup>

defineProps({
  name: {
    type: String,
  },
});
</script>

<template>
  <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-400 rounded-full">
    <span class="font-black text-black">{{ name.charAt(0) }}</span>
  </div>
</template>
