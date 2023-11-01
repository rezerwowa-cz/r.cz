<script setup>
import {ref, onMounted} from 'vue'
import Layout from '@/Layouts/Default.vue';
import moment from 'moment';
import Card from '@/Components/Card.vue';
import Avatar from '@/Components/Page/Avatar.vue';
import { useAutoAnimate } from '@formkit/auto-animate/vue'
import {useForm} from "@inertiajs/inertia-vue3";
import { Swiper, SwiperSlide } from "swiper/vue";
import {FreeMode, Navigation, Pagination, Thumbs} from "swiper";
import "swiper/css";
import "swiper/css/navigation";

import { ChevronLeftIcon } from '@heroicons/vue/solid'
import { ChevronRightIcon } from '@heroicons/vue/solid'

const modules =  [Pagination, Navigation];
const [days, time] = useAutoAnimate()

const props = defineProps({
  service: {
    type: Object,
    default: null,
  },
});

const timetable = ref(null)
const weeks = {
  1: {
    trans: 'Poniedziałek',
    code: 'monday'
  },
  2: {
    trans: 'Wtorek',
    code: 'tuesday'
  },
  3: {
    trans: 'Środa',
    code: 'wednesday'
  },
  4: {
    trans: 'Czwartek',
    code: 'thursday'
  },
  5: {
    trans: 'Piątek',
    code: 'friday'
  },
  6: {
    trans: 'Sobota',
    code: 'saturday'
  },
  7: {
    trans: 'Niedziela',
    code: 'sunday'
  },
}

const selectedDay = ref(null)

const selectedIndex = ref(null)

const accessibleDays = ref([])

const serviceStep = ref(null)

onMounted(() => {
  accessibleDays.value = props.service.data.timetables.map(table => table.day)
})
const form = useForm({
  date: null,
  time: null
})

const submit = () => {
  form.post(route('service.order.store', props.service.data.id), {
    onFinish: () => {
      form.reset();
    },
  });
};

function getWeekName(DayNumber) {
  return weeks[DayNumber] ? weeks[DayNumber].trans : null;
}
function getWeekCode(DayNumber) {
  return weeks[DayNumber] ? weeks[DayNumber].code : null;
}
function pickDay(Date, day, index) {
  if(accessibleDays.value.includes(getWeekCode(Date.isoWeekday()))) {
    getTimetable(Date.format('DD-MM-YYYY'), day, index)
    form.time = null;
    form.date = Date.format('DD-MM-YYYY');
  }
}

function pickTime(time, available, step) {
  if(available) {
    form.time = time;
    serviceStep.value = step;
  }
}

function getTimetable(date, day, index) {
  axios.get(route('service.timetable', props.service.data), {
    params: {date: date }
  }).then(response => {
    selectedIndex.value = index;
    selectedDay.value = day;
    timetable.value = response.data.data;
  });
}

</script>
<template>
  <Layout title="Rezerwacja usługi">
    <form  class="mb-24" @submit.prevent="submit">
    <div class="p-6 pt-24 pb-24">
      <div class="flex items-center justify-center">
        <div class="flex flex-col items-center gap-y-6">
          <h1 class="">Rezerwacja usługi</h1>
          <span class="text-xl"> {{ service.data?.name }} <span class="font-semibold">{{ service.data?.price }}</span> </span>
        </div>
      </div>
    </div>
    <div class="flex flex-col gap-y-6 text-center mb-14">
      <span class="font-semibold text-lg">Wybierz dzień rezerwacji</span>
      <div class=" justify-center relative px-8">
        <swiper
            :slidesPerView="2"
            :spaceBetween="15"
            :slidesPerGroup="2"
            :breakpoints="{
              '640': {
                slidesPerView: 2,
                spaceBetween: 15,
                slidesPerGroup: 2,
              },
              '768': {
                slidesPerView: 4,
                spaceBetween: 15,
                slidesPerGroup: 4,
              },
              '1024': {
                slidesPerView: 7,
                spaceBetween: 15,
                slidesPerGroup: 7,
              },
            }"
            :pagination="{
              clickable: true,
            }"
            :navigation="{
              nextEl: '.button-next',
              prevEl: '.button-prev',
            }"

            :modules="modules"
            class="swiper-days"
        >
          <swiper-slide
              class="btn pointer transition-all duration-300 ease-in-out flex flex-col"
              v-for="index in 21" :key="index"
              @click="pickDay(moment().add(index - 1, 'days'), moment().add(index - 1, 'days').isoWeekday(), index)"
              :class="[
                    accessibleDays.includes(getWeekCode(moment().add(index - 1, 'days').isoWeekday())) ? 'cursor-pointer' : 'btn-light opacity-25',
                    selectedIndex === index ? 'btn-primary outline outline-2  outline-offset-2 outline-black' : 'btn-light outline outline-2 outline-offset-4 outline-transparent'
                   ]
              ">
            <div>
              {{ moment().add(index - 1, 'days').format('DD.MM') }}
            </div>
            <div>
              {{ getWeekName(moment().add(index - 1, 'days').isoWeekday()) }}
            </div>
          </swiper-slide>
        </swiper>
        <div class="button-prev absolute inset-y-0 left-0 flex items-center cursor-pointer">
          <ChevronLeftIcon class="h-7 w-7 text-black  "/>
        </div>
        <div class="button-next absolute inset-y-0 right-0 flex items-center cursor-pointer">
          <ChevronRightIcon class="h-7 w-7 text-black  "/>
        </div>
      </div>
      <span class="font-semibold text-lg">Wybierz godzinę rezerwacji</span>
      <div ref="days">
        <div class="mb-4">{{ getWeekName(selectedDay) }}</div>
        <div v-if="timetable?.timetables" class="flex gap-x-3 gap-y-3 justify-center flex-wrap">
        <span @click="pickTime(item.time, item.available, item.step)"
              class="btn pointer transition-all duration-300 ease-in-out"
              v-for="item in timetable.timetables"
              :key="item"
              :class="[item.available ? 'cursor-pointer' : 'opacity-50', form.time === item.time ? 'btn-primary outline outline-2  outline-offset-2 outline-black' : 'btn-light btn-light outline outline-2 outline-offset-4 outline-transparent']"
        >
            {{ item.time  }}
        </span>
        </div>
        <div v-else>
          Wybierz w pierwszej kolejności dzień aby zobaczyć dostępne godziny.
        </div>
      </div>
    </div>
    <div class="px-8" v-if="selectedDay">
      <Card class="flex flex-col gap-y-3">
        <div class="flex items-center justify-between ">
          <h3>{{ service.data?.name }}</h3>
          <span class=" bg-gray-200 px-3 py-1 rounded-8 ">
            {{ form.time ?? '--:--' }} - {{ form.time ? moment(form.time, 'HH:mm').add(serviceStep, 'minutes').format("HH:mm") : '--:--' }}
          </span>
        </div>
        <div class="flex justify-between">
          <h5>{{ service.data?.price }}</h5>
          <div v-if="form.time">
            Czas trwania: <span class="text-semibold">{{ moment(serviceStep, 'mm').format("mm") }}</span> min
          </div>
        </div>
        <div>
          {{ form.date }}
          {{ getWeekName(selectedDay) }}
        </div>
        <div class="flex items-center space-x-4">
          <Avatar :name="service.data.creator.name"/>
          <div>
            <div class="font-semibold ">{{ service.data.creator.name }}</div>
            <div >{{ service.data.creator.email }}</div>
          </div>
        </div>
      </Card>
    </div>
    <div class="px-8 mt-14 flex items-end justify-end" v-if="form.time && form.date">
      <button class="btn btn-primary" type="submit" :disabled="form.processing">Rezerwuj termin</button>
    </div>
    </form>
  </Layout>
</template>



<style scoped>
:global(.swiper-days .swiper-wrapper) {
  padding: 10px 0px;
}
:global(.button-next.swiper-button-disabled) {
  opacity: 0.40;
}
:global(.button-prev.swiper-button-disabled) {
  opacity: 0.40;
}
</style>
