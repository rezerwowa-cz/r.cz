<script setup>
import Layout from '@/Layouts/Default.vue';
import Card from '@/Components/Card.vue';
import Avatar from '@/Components/Page/Avatar.vue';
import moment from 'moment';

const props = defineProps({
  order: {
    type: Object,
    default: null,
  },
  service: {
    type: Object,
    default: null,
  },
});

</script>
<template>
  <Layout title="Zrealizowane zamówienie">
    <div class="mt-24 px-3">
      <div class="w-100 text-center mb-14 ">
        <span class="bg-green-100 text-green-800 px-3 font-medium mr-2 px-2.5 py-0.5 rounded">Zamówienie udane.</span>
      </div>
      <Card class="flex flex-col gap-y-3">
        <div>
          <h3>{{ service.data.name }}</h3>
        </div>
        <div>
          <h5>{{ service.data.price }}</h5>
        </div>
        <div>
            <span class="font-semibold ">
              {{ moment(order.service_date).utc().format('hh:mm') }}
            </span>
          {{ moment(order.service_date).format('DD.MM.YYYY') }}
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
  </Layout>
</template>
