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
        :value="selectedChoice ? JSON.stringify(selectedChoice) : ''"
      >
      <div class="relative">
        <ComboboxInput
          v-debounce:400ms.trim.cancelonempty.unlock="execSearch"
          :debounce-events="['keydown']"
          autocomplete="off"
          v-bind="attributes"
          :style="hasErrors ? 'border: solid 2px rgb(220 38 38);': ''"
          :display-value="(choice) => choice?.label"
          @click.stop="$event.target.select(); show = !show"
        />
        <ComboboxButton
          v-if="!attributes.disabled"
          class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none"
        >
          <ChevronUpDownIcon
            class="h-5 w-5 text-gray-400"
            aria-hidden="true"
          />
        </ComboboxButton>

        <div
          v-if="loading"
          class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <div
            class="py-2 pl-3 pr-9 text-gray-900"
          >
            Suche nach Akten...
          </div>
        </div>
        <ComboboxOptions
          v-else
          :static="show"
          class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <div
            v-if="choices.length > 0"
          >
            <ComboboxOption
              v-for="choice in choices"
              :key="choice.data"
              v-slot="{ active, selected }"
              :value="choice"
              as="template"
            >
              <li :class="['relative cursor-pointer select-none py-2 pl-3 pr-9 group', active ? 'bg-primary-600 text-white' : 'text-gray-900']">
                <div :class="['block truncate', selected && 'font-semibold']">
                  <span class="font-semibold flex">{{ choice.label }}</span>
                  <span
                    v-if="choice.description"
                    class="text-sm flex"
                    :class="active ? 'text-gray-50 font-normal' : 'text-gray-600 group-hover:text-gray-50'"
                  >
                    {{ choice.description }}
                  </span>
                </div>
                <span
                  v-if="selected"
                  :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-primary-600']"
                >
                  <CheckIcon
                    class="h-5 w-5"
                    aria-hidden="true"
                  />
                </span>
              </li>
            </ComboboxOption>
          </div>
          <div
            v-else-if="choices.length === 0 && query.length === 0"
            class="py-2 pl-3 pr-9 text-gray-900"
          >
            Zum Suchen mindestens 4 Zeichen eingeben
          </div>
          <div
            v-else-if="errorMessage !== ''"
            class="py-2 pl-3 pr-9 text-yellow-700"
          >
            {{ errorMessage }}
          </div>
          <div
            v-else
            class="py-2 pl-3 pr-9 text-gray-900"
          >
            Keine Akten mit "{{ query }}" gefunden
          </div>
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
import { onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  name: { type: String, required: true },
  url: { type: String, required: true },
  attributes: { type: Object, required: true },
  value: { type: Object, required: false, default: () => null },
  hasErrors: { type: Boolean, required: false, default: () => false },
})

const comboboxWrapper = ref()
const show = ref(false)

const query = ref('')
const selectedChoice = ref(props.value ? props.value : undefined)
const loading = ref(false)
const choices = ref(props.value ? [props.value] : [])
const errorMessage = ref('')

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

watch(query, () => {
  if (!query.value) {
    choices.value = []
    show.value = false

    return
  }

  if (query.value.length <= 4) {
    choices.value = []
    show.value = false

    return
  }

  loading.value = true
  errorMessage.value = ''
  choices.value = []

  fetch(`${props.url}?query=${query.value}`)
    .then(response => response.json())
    .then(data => {
      show.value = true
      choices.value = data
    }).catch(() => (errorMessage.value = 'Die Suche ist momentan nicht verfügbar. Bitte versuche es später erneut.'))
    .finally(() => {
      loading.value = false
    })
})

watch(selectedChoice, () => {
  if (selectedChoice.value === null) {
    return
  }

  show.value = false
})

const execSearch = (value, event) => {
  if (event.key === 'Enter') {
    event.preventDefault()
  }

  query.value = value
}
</script>
