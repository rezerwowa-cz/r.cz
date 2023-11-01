<script setup>
import Layout from '@/Layouts/Default.vue';
import {ref} from "vue";
const props = defineProps({
  orders: {
    type: Object,
    default: null,
  },
});

const status = {
  "complete": 'Udane',
}

function getStatusTanslate(value) {
  let color;
  value === 'complete' ? color = 'text-green-600' : color = 'text-black';
  return status[value] ? `<span class="${color}"> ${status[value]} </span>` : '-';
}
</script>
<template>
  <Layout title="Lista zamówień">
    <div class="mt-14 mb-24">
      <h5 class="mb-3">Lista rezerwacji</h5>
      <div class="relative overflow-x-auto rounded-8 border border-black">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
          <tr>
            <th scope="col" class="px-6 py-3">
              Nazwa
            </th>
            <th scope="col" class="px-6 py-3">
              <div class="flex items-center">
                Cena
              </div>
            </th>
            <th scope="col" class="px-6 py-3">
              <div class="flex items-center">
                Termin
              </div>
            </th>
            <th scope="col" class="px-6 py-3">
              <div class="flex items-center">
                Status
              </div>
            </th>
          </tr>
          </thead>
          <tbody>
          <tr class="border-b" v-for="order in orders.data">
            <td class="px-6 py-4 font-semibold text-black whitespace-nowrap">
              {{ order.service.name }}
            </td>
            <td class="px-6 py-4">
              {{ order.price }}
            </td>
            <td class="px-6 py-4">
              {{ order.datetime }}
            </td>
            <td class="px-6 py-4">
              <span v-html="getStatusTanslate(order.status)" />
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </Layout>
</template>
