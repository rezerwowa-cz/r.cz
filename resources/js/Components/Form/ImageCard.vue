<script setup>
defineProps({
  thumbnail: {
    type: String,
    default: null,
  },
  canEdit: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <div class="group relative border border-black rounded-8 overflow-hidden ">
    <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1  overflow-hidden  lg:h-40 lg:aspect-none">
      <img :src="thumbnail" alt="Service Image" class="w-full h-full object-center object-contain lg:w-full lg:h-full">
    </div>
    <div class=" flex justify-between px-5 py-5 text-black">
      <div class="w-full flex flex-col gap-y-2 items-end">
        <slot name="body"></slot>
      </div>
    </div>
  </div>
</template>
