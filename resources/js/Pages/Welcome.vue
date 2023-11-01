<script setup>
import { ref } from 'vue'
import Layout from '@/Layouts/Default.vue';
import Card from '@/Components/ProductCard.vue';
import Search from '@/Components/Search/SearchServices.vue';
import {Link} from '@inertiajs/inertia-vue3';
// import { onMounted, ref } from 'vue';
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    services: Object,
    categories: Object
});

const searchData = ref([])

function searchResults(services) {
  searchData.value = services
}

function setResults() {
  return searchData.value.length > 0 ? searchData.value : props.services.data;
}

</script>

<template>
  <Layout title="TEST" :can-login="canLogin" :can-register="canRegister">
    <div class="mt-8 text-black overflow-hidden w-full">
      <div class="grid grid-cols-1 w-full">
        <div class="p-6 py-32">
          <div class="flex items-center justify-center">
            <div class="flex flex-col items-center gap-y-6">
              <h1 class="">System rezerwacji usług.</h1>
              <span class="text-xl"> Teraz z łatwością zarezerwujesz swoją ulubioną usługę!</span>
              <div class="flex gap-x-3">
                <Link v-if="$page.props.user" :href="route('user')" class="btn-light btn">
                  Twój profil
                </Link>
                <template v-else>
                  <Link :href="route('login')" class="btn-light btn">
                    Zaloguj
                  </Link>
                  <Link v-if="canRegister" :href="route('register')" class="btn-primary btn">
                    Rejestracja
                  </Link>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full ">
      <div class="text-center flex flex-col gap-y-3">
        <span class="font-semibold">Polecane dla Ciebie</span>
        <h1 class="mb-6">Szukaj usługi dla Ciebie</h1>
      </div>
      <Search :categories="categories" @update="searchResults($event)" />
      <div class="text-center">
          <span class=" text-xs ">
            Wpisz szukaną usługę oraz wybierz kategorie.
          </span>
      </div>
    </div>
    <section aria-labelledby="pricing-title" class="text-black py-14 sm:py-32">
      <div class="mx-auto max-w-7xl px-4">
        <span v-if="searchData.length > 0" class="btn btn-primary" @click="resetSearch()">Resetuj wyszukiwanie</span>
        <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
          <Card v-for="service in setResults()" :link="route('services.show', service)" :thumbnail="service.thumbnail">
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
          </Card>
          <!-- More products... -->
        </div>
      </div>
    </section>
  </Layout>
</template>
