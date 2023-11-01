<script setup>
import Layout from '@/Layouts/Default.vue';
import ProductCard from '@/Components/ProductCard.vue';
import Breadcrumb from '@/Components/Page/Breadcrumb.vue';
import Avatar from '@/Components/Page/Avatar.vue';
import {ref} from "vue";

const props = defineProps({
  services: {
    type: Object,
    default: null,
  },
  user: {
    type: Object,
    default: null,
  },
});


const pages = ref([
  {
    title: "Strona główna",
  },
  {
    title: "Usługi użytkownika "  + props.user.name,
    current: true
  },
])
</script>

<template>
  <Layout title="Profil">
    <Breadcrumb class="pt-16 mb-4" :pages="pages"></Breadcrumb>
    <div class="mb-4 flex justify-between ">
      <div class="flex items-center space-x-4">
        <Avatar :name="user.name"/>
        <div>
          <div class="font-semibold ">{{ user.name }}
            <template v-if="$page.props.user && user.id === $page.props.user.id">
              <span class=" font-normal " >(Ty)</span>
              <a class="btn btn-light ml-4"  :href="route('profile.show')">Edytuj</a>
            </template>
          </div>

        </div>
      </div>
      <template v-if="$page.props.user && user.id === $page.props.user.id">
        <div class="space-x-2 flex">
          <a class="btn btn-light"  :href="route('service.orders')">Lista zamówień</a>
          <a class="btn btn-primary"  :href="route('services.create')">Dodaj nową usługę</a>
        </div>
      </template>
    </div>
    <section aria-labelledby="pricing-title" class="text-black py-4 sm:py-10">
      <h5>
        Usługi dodane przez Ciebie
      </h5>
      <div class="mx-auto max-w-7xl">
        <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
          <ProductCard :can-edit="true" v-for="service in services.data" :link="route('services.show', service)" :thumbnail="service.thumbnail">
            <template v-if="service.categories.length > 0 " v-slot:category>
              {{ service.categories[0].name }}
            </template>
            <template v-slot:name>
              {{ service.name }}
            </template>
            <template v-slot:city>
              {{ service.address.city }}
            </template>
            <template v-slot:price>
              {{ service.price }}
            </template>
          </ProductCard>
          <!-- More products... -->
        </div>
      </div>
    </section>
  </Layout>
</template>

<style scoped>

</style>
