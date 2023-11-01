<script setup>
import Calendar from 'primevue/calendar';
import {ref} from "vue";

const startTime = ref()
const endTime = ref()
const time = ref()
const limit = ref()

defineEmits(['update:values']);

defineProps({
  day: {
    type: String,
    default: null,
  },
});
</script>

<template>
  <div>
    <span class="text-lg font-semibold">
      <slot name="title"></slot>
    </span>
    <div class="w-full grid grid-cols-2 gap-y-6 gap-x-3 ">
      <div class="form-group">
        <label >Godzina początkowa</label>
        <Calendar @date-select="$emit('update:values', {event: $event, type: 'from', day: day})" class="input-form" inputId="time24" v-model="startTime" :showTime="true" :timeOnly="true" />
      </div>
      <div class="form-group">
        <label >Godzina końcowa</label>
        <Calendar @date-select="$emit('update:values', {event: $event, type: 'to', day: day})" class="input-form" inputId="time24" v-model="endTime" :showTime="true" :timeOnly="true" />
      </div>
      <div class="col-span-2 form-group">
        <label >Czas jednej wizyty (krok)</label>
        <input @input="$emit('update:values', {event: $event, type: 'step', day: day})" v-model="time" class="input-form" type="number" name="number" placeholder="Wyszukaj usługę.."/>
      </div>
      <div class="col-span-2 form-group">
        <label >Limit osoby na jedną sesje</label>
        <input @change="$emit('update:values', {event: $event, type: 'limit', day: day})" v-model="limit" class="input-form" type="number" name="number" placeholder="Wyszukaj usługę.."/>
      </div>
    </div>
  </div>
</template>
