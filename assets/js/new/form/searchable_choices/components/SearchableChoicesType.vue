<template>
  <div ref="comboboxWrapper">
    <Combobox
      v-model="selectedChoice"
      as="div"
      class="z-40"
    >
      <input
        :id="id"
        type="hidden"
        :name="name"
        :value="selectedChoice ? selectedChoice.value : ''"
      >
      <div class="relative">
        <ComboboxInput
          v-bind="attributes"
          :style="hasErrors ? 'border: solid 2px rgb(220 38 38);': ''"
          :display-value="(choice) => choice?.label"
          @change="query = $event.target.value"
          @click.stop="$event.target.select(); show = !show"
        />
        <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
          <ChevronUpDownIcon
            class="h-5 w-5 text-gray-400"
            aria-hidden="true"
          />
        </ComboboxButton>

        <ComboboxOptions
          v-if="filteredChoices.length > 0"
          :static="show"
          class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <ComboboxOption
            v-for="choice in filteredChoices"
            :key="choice.data"
            v-slot="{ active, selected }"
            :value="choice"
            as="template"
          >
            <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-primary-600 text-white' : 'text-gray-900']">
              <span :class="['block truncate', selected && 'font-semibold']">
                {{ choice.label }}
              </span>
              <span
                v-if="selected"
                :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-indigo-600']"
              >
                <CheckIcon
                  class="h-5 w-5"
                  aria-hidden="true"
                />
              </span>
            </li>
          </ComboboxOption>
        </ComboboxOptions>
      </div>
    </Combobox>
  </div>
</template>

<script setup>
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxOption,
  ComboboxOptions,
} from '@headlessui/vue'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  name: { type: String, required: true },
  attributes: { type: Object, required: true },
  choices: { type: Array, required: false, default: () => [] },
  value: { type: String, required: false, default: () => null },
  hasErrors: { type: Boolean, required: false, default: () => false },
})

const comboboxWrapper = ref()
const show = ref(false)

const query = ref('')
const selectedChoice = ref(props.value !== null ? props.choices.find(choice => choice.value === props.value) : null)
const filteredChoices = computed(() =>
  query.value === ''
    ? props.choices
    : props.choices.filter((choice) => {
      return choice.label.toLowerCase().includes(query.value.toLowerCase())
    }),
)

const clickHandler = (event) => {
  if (comboboxWrapper.value.contains(event.target)) {
    return
  }

  show.value = false
}

onMounted(() => {
  if (typeof comboboxWrapper.value === 'undefined') {
    return
  }

  document.addEventListener('click', clickHandler)
})

onUnmounted(() => {
  document.removeEventListener('click', clickHandler)
})

watch(selectedChoice, () => {
  if (selectedChoice.value === null) {
    return
  }

  show.value = false
})
</script>
