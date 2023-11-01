<script setup>

defineProps({
  thumbnail: {
    type: String,
    default: 'https://i.imgur.com/5TFgGcJ.png',
  },
});
</script>

<template>
  <div class="group relative border border-black rounded-8 overflow-hidden px-6 py-6">
    <slot></slot>
  </div>
</template>
