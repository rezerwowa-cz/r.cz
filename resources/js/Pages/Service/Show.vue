<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';

import {FreeMode,Pagination, Navigation,Thumbs} from 'swiper';
import {ref, toRefs, onMounted} from 'vue'
import Layout from '@/Layouts/Default.vue';
import Breadcrumb from '@/Components/Page/Breadcrumb.vue';
import Avatar from '@/Components/Page/Avatar.vue';
import Disclosure from '@/Components/Disclosure.vue';
import "swiper/css";

const props = defineProps({
  service: {
    type: Object,
    default: null,
  },
});
const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper;
}
const modules =  [FreeMode, Pagination, Navigation,Thumbs];

const pages = ref([
  {
    title: "Strona główna",
  },
  {
    title: "Usługi",
  },
  {
    title: props.service.data.name,
    current: true
  },
])

onMounted(() => {
  console.log(props.service.data)
})

</script>

<template>
  <Layout title="Podgląd usługi">
    <Breadcrumb class="pt-16" :pages="pages"></Breadcrumb>
    <div class="md:grid md:grid-cols-5 mb-20 md:gap-6">
      <div class="mt-5 md:col-span-3 md:mt-0">
        <swiper
            :style="{
      '--swiper-navigation-color': '#fff',
      '--swiper-pagination-color': '#fff',
    }"
            :spaceBetween="10"
            :pagination="{
                type: 'fraction',
            }"
            :navigation="true"
            :thumbs="{ swiper: thumbsSwiper }"
            :modules="modules"
            class="mySwiper2 rounded-8"
        >
          <swiper-slide v-for="image in service.data.gallery">
            <img class="w-full"
              :src="image"/>
          </swiper-slide>

        </swiper>
        <swiper
            @swiper="setThumbsSwiper"
            :spaceBetween="10"
            :slidesPerView="5"
            :autoHeight="false"
            :watchSlidesProgress="true"
            :modules="modules"
            class="thumbs mt-3"
        >
          <swiper-slide v-for="image in service.data.gallery" class="rounded-8 ">
            <img :src="image" />
          </swiper-slide>
        </swiper>
        <div>
          <Disclosure v-if="service.data?.description">
            <template #title>
              Opis
            </template>
            <template #body>
              {{ service.data.description }}
            </template>
          </Disclosure>
        </div>
      </div>
      <div class="md:col-span-2 flex flex-col gap-y-5">
        <div class="flex flex-col gap-y-3">
          <h4>
            {{ service.data.name }}
          </h4>
          <h5>
            {{ service.data.price }}
          </h5>
        </div>
        <div class="flex flex-col gap-y-3">
          <span class="font-semibold">Twórca</span>
          <div class="flex items-center space-x-4">
            <Avatar :name="service.data.creator.name"/>
            <div>
              <div class="font-semibold ">{{ service.data.creator.name }}</div>
              <div >{{ service.data.creator.email }}</div>
            </div>
          </div>

        </div>
        <hr class="border-black">
        <div class="flex text-sm justify-end">
          <span>
             Data dołączenia {{ new Date(service.data.creator.created_at).toLocaleDateString('pl-PL') }}
          </span>
        </div>
        <div class="flex flex-col gap-y-3">
          <span class="font-semibold">Dokonaj rezerwacji</span>
          <a :href="route('service.order', service.data)" class="w-100 text-center btn btn-primary">
            Rezerwuj usługę
          </a>
          <span class="w-100 text-center text-xs">
          Dokonaj rezerwacji już teraz, termin może zostać w każdej chwili zajęty.
        </span>
        </div>
      </div>
    </div>
  </Layout>
</template>

<style scoped>
:deep(.swiper-pagination.swiper-pagination-fraction.swiper-pagination-horizontal) {
   background-color: black;
   border-radius: 6px;
   color: white;
   position: absolute;
   bottom: 10px;
   z-index: 2;
   padding: 2px 12px;
   right: 10px;
   left: unset!important;
   font-weight: bolder;
 }
:deep(.thumbs .swiper-slide-thumb-active) {
  border: solid 3px #d3d4d5;
  border-radius: 7px;
}
</style>
