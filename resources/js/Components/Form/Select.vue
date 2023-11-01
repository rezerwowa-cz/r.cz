<script setup>
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/solid'
import {ref} from "vue";

const selectedCat = ref({
  name: 'Wybierz kategorie',
  id: null
});

defineProps({
    modelValue: {
      type: Object,
    },
    placeholder: String,
    list: Object
});

const emit = defineEmits(['update:modelValue']);

// function test(v) {
//   console.log(v);
//   emit('update:modelValue', v)
// }




</script>

<template>
  <Listbox v-model="modelValue"
           @update:modelValue="value => emit('update:modelValue', {name: value.name, id: value.id})"
           v-slot="{ open }"
  >
    <div class="relative input-form" :class="[open ? 'border-indigo-500 ring-1 ring-indigo-500' : '' ]">
      <ListboxButton
          class="px-2 py-2 w-full h-full text-left "
      >
        <span class="block truncate text-black/70 ">{{ modelValue.name ?? placeholder }}</span>
        <span
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
        >
            <ChevronDownIcon
                class="h-5 w-5 text-gray-400"
                aria-hidden="true"
            />
          </span>
      </ListboxButton>

      <transition
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
      >
        <ListboxOptions
            class="absolute z-30 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <ListboxOption
              v-slot="{ active, selected }"
              v-for="item in list"
              :key="item.id"
              :value="item"
              as="template"
          >
            <li
                :class="[
                  active ? 'bg-black text-white' : 'text-gray-900',
                  'relative cursor-default select-none py-2 pl-2 cursor-pointer pr-4',
                ]"
            >
                <span
                    :class="[
                    selected ? 'font-semibold' : 'font-normal',
                    'block truncate',
                  ]"
                >{{ item.name }}</span
                >
              <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
              >
                </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>
