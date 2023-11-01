<script setup>
import { ref, watch } from 'vue'
import Layout from '@/Layouts/Default.vue';
import Card from '@/Components/Card.vue';
import DayCard from '@/Components/Service/FormDay.vue';
import { useAutoAnimate } from '@formkit/auto-animate/vue'
import SystemInput from '@/Components/Form/Input.vue';
import FormSelect from '@/Components/Form/Select.vue';
import FormGroup from '@/Components/Form/Group.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import ImageCard from '@/Components/Form/ImageCard.vue';

defineProps({
  categories: {
    type: Object,
    default: null,
  },
});

const [parent, images] = useAutoAnimate()

const photos = ref([]);


const week = ref({
  monday: {check: false},
  tuesday: {check: false},
  wednesday: {check: false},
  thursday: {check: false},
  friday: {check: false}
})


const weekTranslate = ref({
  "monday": 'Poniedziałek',
  "tuesday": 'Wtorek',
  "wednesday": 'Środa',
  "thursday": 'Czwartek',
  "friday": 'Piątek'
})

const currency = ref(
    [
      {
        name: 'PLN',
        id: 'PLN'
      },
      {
        name: 'EUR',
        id: 'EUR'
      },
      {
        name: 'USD',
        id: 'USD'
      }
    ]
);

const initCurrency = ref(
      {
        name: 'PLN',
        id: 'PLN'
      },
);
const initCat = ref(
    {},
);
const initCountry = ref(
    { id: 'PL', name: 'Polska'},
);

const countries = ref([
  {id: 'PL', name: 'Polska'},
  {id: 'AX', name: 'Aland Islands'},
])

watch(initCurrency, (val) => {
  form.currency = val.id;
});

watch(initCat, (val) => {
  form.categories = val.id;
});

watch(initCountry, (val) => {
  form.address.country = val.id;
});


const form = useForm({
  name: '',
  description: '',
  price: '',
  currency: initCurrency.value.id,
  photos: [],
  address: {
    country: initCountry.value.id,
    zip_code: '',
    city: '',
    street: '',
    house: '',
    apartment: null,
    telephone: ''
  },
  categories: '',
  timetable: []
})

const photosPreview = ref([])


function activeDay(day) {
  if(week.value[day].check) {
    week.value[day].check = false
    form.timetable = form.timetable.filter((item) => {
      if (day === item.day) {
        form.timetable.push(item)
        return false
      }
      return true
    })
  } else {
    week.value[day].check = true;
    form.timetable.push({
      day: day,
      from: '',
      to: '',
      step: '',
      limit: '',
    })
  }
}

function filesAdd(event) {
  form.photos = [...form.photos, ...event.target.files]
  createImage(event.target.files);
}
function createImage(files) {
  for (let index = 0; index < files.length; index++) {
    const reader = new FileReader();
    reader.onload = function(event) {
      photosPreview.value.push(event.target.result);
    }
    reader.readAsDataURL(files[index]);
  }
}
function removeImage(index) {
  photosPreview.value.splice(index, 1)
  form.photos.splice(index, 1)
}

function AddZero(item) {
  return (item < 10 ? '0' : '') + item;
}

function UpdateValues(value) {
  const item = form.timetable.filter((item) => item.day === value.day)

  if(value.type === 'from' || value.type === 'to') {
    item[0][value.type] = AddZero(value.event.getHours()) + ':' + AddZero(value.event.getMinutes());
  } else {
    item[0][value.type] = value.event.target.value;
  }
}

const submit = () => {
  form.post(route('services.store'), {
    onFinish: () => {
      form.reset();
    },
  });
};

</script>
<template>
  <Layout title="Tworzenie rezerwacji"  >
    {{ form }}
    <form  @submit.prevent="submit">
    <div class="text-black w-full">
      <div class="grid grid-cols-1 w-full">
        <div class="p-6 py-16">
          <div class="flex items-center justify-center">
            <div class="flex flex-col items-center gap-y-6">
              <h1>Tworzenie usługi</h1>
              <span> Uzupełnij dane dotyczące rezerwacji usługi.</span>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="p-6 py-5">
          <div class="flex gap-y-3 flex-col items-center justify-center" >
            <div class="mt-6 w-full grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-2 xl:gap-x-8">
              <div class="w-full grid grid-cols-2 gap-y-6 gap-x-3 ">
                <FormGroup class="col-span-2" :name="'name'">
                  <template #label>
                    Nazwa usługi
                  </template>
                  <SystemInput
                      v-model="form.name"
                      type="text"
                      required
                      autofocus
                      placeholder="Nazwa usługi"
                      autocomplete="name"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup class="col-span-2" :name="'description'">
                  <template #label>
                    Opis usługi
                  </template>
                  <SystemInput
                      v-model="form.description"
                      type="text"
                      required
                      placeholder="Opis usługi"
                      autocomplete="description"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup :name="'price'">
                  <template #label>
                    Cena usługi
                  </template>
                  <SystemInput
                      v-model="form.price"
                      type="number"
                      required
                      placeholder="Cena usługi"
                      autocomplete="price"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup :name="'currency'">
                  <template #label>
                    Waluta usługi
                  </template>
                    <FormSelect
                        v-model="initCurrency"
                        :list="currency"
                        :placeholder="'Wybierz walutę'"
                    ></FormSelect>
                </FormGroup>
                <FormGroup class="col-span-2" :name="'categories'">
                  <template #label>
                    Kategoria usługi
                  </template>
                  <FormSelect
                      v-model="initCat"
                      :list="categories"
                      :placeholder="'Wybierz kategorię'"
                  ></FormSelect>
                </FormGroup>
              </div>
              <div class="w-full grid grid-cols-2 gap-y-6 gap-x-3 content-start">
                <FormGroup :name="'city'">
                  <template #label>
                    Miasto
                  </template>
                  <SystemInput
                      v-model="form.address.city"
                      type="text"
                      required
                      placeholder="Miasto"
                      autocomplete="city"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup :name="'street'">
                  <template #label>
                    Ulica
                  </template>
                  <SystemInput
                      v-model="form.address.street"
                      type="text"
                      required
                      placeholder="Ulica"
                      autocomplete="street"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup :name="'house'">
                  <template #label>
                    Nr domu
                  </template>
                  <SystemInput
                      v-model="form.address.house"
                      type="text"
                      placeholder="Nr domu"
                      autocomplete="house"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup :name="'apartment'">
                  <template #label>
                    Nr mieszkania
                  </template>
                  <SystemInput
                      v-model="form.address.apartment"
                      type="text"
                      placeholder="Nr mieszkania"
                      autocomplete="apartment"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup :name="'zip_code'">
                  <template #label>
                    Kod pocztowy
                  </template>
                  <SystemInput
                      v-model="form.address.zip_code"
                      type="text"
                      placeholder="Kod pocztowy"
                      autocomplete="zip_code"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup :name="'telephone'">
                  <template #label>
                    Numer telefonu
                  </template>
                  <SystemInput
                      v-model="form.address.telephone"
                      type="text"
                      placeholder="Numer telefonu"
                      autocomplete="telephone"
                  >
                  </SystemInput>
                </FormGroup>
                <FormGroup class="col-span-2" :name="'country'">
                  <template #label>
                    Wybierz kraj
                  </template>
                  <FormSelect
                      v-model="initCountry"
                      :list="countries"
                      :placeholder="'Wybierz kraj'"
                  ></FormSelect>
                </FormGroup>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mb-24">
      <div class="mt-8 text-black  w-full">
        <div class="grid grid-cols-1 w-full">
          <div class="p-6 py-16">
            <div class="flex gap-y-3 flex-col items-center justify-center">
              <div class="flex flex-col items-center gap-y-6">
                <span>Zaznacz aktywne dni tygodnia dla usługi.</span>
              </div>
              <div class="flex gap-x-3 gap-y-3 flex-wrap">
                <span v-for="(day, index) in week" class="btn cursor-pointer"
                      :class="[day.check ? 'btn-primary' : 'btn-light']"
                      @click="activeDay(index)"
                >
                  {{ weekTranslate[index] }}
                </span>
              </div>

              <div class="mt-6 w-full grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8" ref="parent">
                <div :key="timetable['day']" v-for="(timetable, index) in form.timetable">
                  <card class="flex flex-col gap-y-3">
                    <DayCard
                        class="flex flex-col gap-y-3"
                        :day="timetable['day']"
                        @update:values="UpdateValues($event)"
                    >
                      <template v-slot:title>
                        {{ weekTranslate[timetable['day']] }}
                      </template>
                    </DayCard>
                  </card>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="p-6 py-16">
        <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8 mb-10" v-if="photosPreview" ref="images">
          <ImageCard :key="index" v-for="(image, index) in photosPreview" :thumbnail="image">
            <template v-slot:body>
              <button class="btn-danger btn-xs text-xs" @click="removeImage(index)">Usuń</button>
            </template>
          </ImageCard>
        </div>

        <FormGroup :name="'images'">
          <template #label>
            Dodaj zdjęcia
          </template>
          <label class="w-full">
            <input class=" w-full border-black rounded-8  border text-sm text-grey-500
            file:mr-5 file:py-3 file:px-6
            file:rounded-full file:border-0
            file:text-sm file:font-medium
            file:bg-black file:text-white

          "
                   type="file" multiple @input="filesAdd($event)"
            />
          </label>
        </FormGroup>
        <div class="w-full flex justify-end mt-10 ">
          <button class="btn btn-primary" type="submit" :disabled="form.processing">Stwórz usługę</button>
        </div>
      </div>
    </div>
    </form>
  </Layout>
</template>


<style  scoped>
:global(.p-datepicker-timeonly) {
    font-family: 'Inter';
 }
:global(.p-inputtext) {
  border-width: 1px;
}
</style>
