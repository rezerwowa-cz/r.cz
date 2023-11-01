<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Avatar from '@/Components/Page/Avatar.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  title: String,
});

</script>

<template>

    <Head :title="title"/>

    <div class="relative flex items-top  min-h-screen bg-white flex-col sm:pt-0">
      <div class="fixed top-0 right-0 border-b-black border z-50  w-full">
        <Popover class="relative bg-white">
          <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center py-3 md:justify-start md:space-x-10">
              <div class="flex justify-start lg:w-0 lg:flex-1">
                <a href="/" class="font-bold text-xl text-black">
                  Rezerwowa.cz
                </a>
              </div>
              <div class="-mr-2 -my-2 md:hidden">
                <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                  <span class="sr-only">Open menu</span>
                  <MenuIcon class="h-6 w-6" aria-hidden="true"/>
                </PopoverButton>
              </div>
              <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0 space-x-2 ">
                <template v-if="$page.props.user">
                  <div class="space-x-3 mr-3">
                    <Avatar :name="$page.props.user.name"/>
                    <span>
                      {{ $page.props.user.name }}
                    </span>
                  </div>
                <Link v-if="$page.url !== '/user'" :href="route('user')" class="btn-light btn">
                  Twoje usługi
                </Link>
                <Link
                    :href="route('logout')"
                    class="btn-light btn"
                    method="post"
                >
                  Wyloguj
                </Link>
                </template>
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

          <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
              <PopoverPanel focus class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                  <div class="pt-5 pb-6 px-5">
                    <div class="flex items-center justify-between">
                      <div>
                        Rezerwowa.cz
                      </div>
                      <div class="-mr-2">
                        <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-black">
                          <span class="sr-only">Close menu</span>
                          <XIcon class="h-6 w-6" aria-hidden="true"/>
                        </PopoverButton>
                      </div>
                    </div>
                    <div class="mt-6">
                      <nav class="grid gap-y-4">
                        <Link v-if="$page.props.user" :href="route('dashboard')" class="btn-light btn">
                          Dashboard
                        </Link>
                        <template v-else>
                          <Link :href="route('login')" class="btn-light btn">
                            Zaloguj
                          </Link>
                          <Link v-if="canRegister" :href="route('register')" class="btn-primary btn">
                            Rejestracja
                          </Link>
                        </template>
                      </nav>
                    </div>
                  </div>
                </div>
              </PopoverPanel>
          </transition>
        </Popover>
      </div>
      <main class="max-w-7xl mx-auto sm:px-4 lg:px-6 mt-20 w-full">
        <slot />
      </main>
    </div>

</template>
<script>
import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'
import {
  BookmarkAltIcon,
  CalendarIcon,
  ChartBarIcon,
  CursorClickIcon,
  MenuIcon,
  PhoneIcon,
  PlayIcon,
  RefreshIcon,
  ShieldCheckIcon,
  SupportIcon,
  ViewGridIcon,
  XIcon,
} from '@heroicons/vue/outline'
import { ChevronDownIcon } from '@heroicons/vue/solid'

const callsToAction = [
  { name: 'Watch Demo', href: '#', icon: PlayIcon },
  { name: 'Contact Sales', href: '#', icon: PhoneIcon },
]
const resources = [
  {
    name: 'Barber',
    description: '-',
    href: '#',
    icon: SupportIcon,
  },
  {
    name: 'Osiedlowe Kino',
    description: '-',
    href: '#',
    icon: BookmarkAltIcon,
  },
  {
    name: 'Eventy',
    description: 'Rezerwacja miejsca na webinar.',
    href: '#',
    icon: CalendarIcon,
  },
]
const recentPosts = [
  { id: 1, name: 'Front-end webinar', href: '#' },
  { id: 2, name: 'Barber golibroda', href: '#' },
]
</script>

