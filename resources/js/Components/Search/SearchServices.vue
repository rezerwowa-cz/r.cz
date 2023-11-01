<script setup>
import { ref, defineEmits } from 'vue'
import { ChevronDownIcon } from '@heroicons/vue/solid'

const props = defineProps({
  categories: Object
});

const emit = defineEmits(['update'])

import {
  Listbox,
  ListboxLabel,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'

function submit() {
  console.log(searchString.value, selectedCat.value.id)
  axios
      .get(route('services.search'), {
        params: {
          category: selectedCat.value.id,
          query: searchString.value,
        }
      })
      .then(response => {

          emit('update', response.data.data)
      });

}

const selectedCat = ref({
      name: 'Wszystkie kategorie',
      id: null
    }),
    searchString = ref('')
</script>

<template>
  <div class="bg-white rounded-lg py-5 px-5 flex justify-between max-w-3xl m-auto">
    <input v-model="searchString" class="input-form rounded-br-none rounded-tr-none " type="text" name="search" placeholder="Wyszukaj usługę.." />
<!--    <input class="input-form rounded-bl-none rounded-tl-none" type="text" name="search" placeholder="Kategoria" />-->
    <Listbox v-model="selectedCat" v-slot="{ open }">
      <div class="relative input-form rounded-bl-none rounded-tl-none" :class="[open ? 'border-indigo-500 ring-1 ring-indigo-500' : '' ]">
        <ListboxButton
            class="px-2 py-2 w-full h-full text-left "
        >
          <span class="block truncate text-black/70 ">{{ selectedCat.name }}</span>
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
              class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
          >
            <ListboxOption
                v-slot="{ active, selected }"
                v-for="category in categories"
                :key="categories.id"
                :value="category"
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
                >{{ category.name }}</span
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
    <a class="ml-2 btn btn-primary cursor-pointer " @click="submit">
      Szukaj
    </a>
  </div>
</template>
