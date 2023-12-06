<template>
  <Menu
    as="div"
    class="relative inline-block text-left w-full"
  >
    <input
      :id="id"
      type="hidden"
      :name="name"
      :value="date ? formatDateISO(date) : ''"
    >
    <div>
      <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <i class="fa-regular fa-calendar fa-fw text-gray-400" />
      </div>
      <MenuButton
        as="input"
        v-bind="attributes"
        :style="hasErrors ? 'border: solid 2px rgb(220 38 38);': ''"
        readonly="readonly"
        :value="date ? formatDate(date) : ''"
      />
      <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
        <button
          type="button"
          class="inline-flex items-center rounded px-2.5 font-sans text-xl text-gray-400 hover:text-gray-800 transition duration-300"
          @click.stop="date = undefined"
        >
          <i class="fa-regular fa-times fa-fw" />
        </button>
      </div>
    </div>

    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        as="div"
        class="absolute left-0 mt-2 z-50 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <DatePicker
          v-model="date"
          expanded
          mode="date"
          color="primary"
          :disabled-dates="disabledDates"
        >
          <template #footer>
            <div class="w-full px-4 pb-3">
              <button
                type="button"
                class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-60 disabled:cursor-not-allowed"
                @click.stop="date = new Date()"
              >
                Heute
              </button>
            </div>
          </template>
        </DatePicker>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
import 'v-calendar/style.css'
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'
import { formatDate, formatDateISO, stringToDate } from '../utils/date_formatter'
import { DatePicker } from 'v-calendar'
import { ref } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  name: { type: String, required: true },
  attributes: { type: Object, required: true },
  value: { type: String, required: false, default: () => null },
  hasErrors: { type: Boolean, required: false, default: () => false },
})

const date = ref(props.value ? stringToDate(props.value) : null)
const disabledDates = ref([
  // { start: new Date().setDate(new Date().getDate() + 1), end: null },
])
</script>
