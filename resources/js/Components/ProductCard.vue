<script setup>
defineProps({
  thumbnail: {
    type: String,
    default: 'https://i.imgur.com/5TFgGcJ.png',
  },
  link: {
    type: String,
    default: false,
  },
  canEdit: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <a :href="link" class="group relative border border-black rounded-8 overflow-hidden flex flex-col">
    <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1  overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
      <img :src="thumbnail" alt="Service Image" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
    </div>
    <div class=" flex justify-between px-5 py-5 text-black grow">
      <div class="w-full flex flex-col gap-y-2">
        <div class="flex flex-col gap-y-2">
          <h3 class="text-sm font-semibold flex justify-between items-center">
            <slot name="category"></slot>
            <span v-if="canEdit" class="btn-primary btn-xs">
              Edytuj
            </span>
          </h3>

          <h3 class="text-sm ">
            <a href="#" class="text-xl font-semibold text-black">
              <slot name="name"></slot>
            </a>
          </h3>
        </div>

        <div class="flex justify-between w-full mt-auto">
          <p class="text-sm text-gray-500">
            <slot name="city"></slot>
          </p>
          <p class="text-xl font-semibold text-black">
            <slot name="price"></slot>
          </p>
        </div>
      </div>
    </div>
  </a>
</template>
