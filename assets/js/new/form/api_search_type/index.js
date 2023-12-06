import Type from './components/ApiSearchType.vue'
import { createApp } from 'vue'
import { vue3Debounce } from 'vue-debounce'

const elements = document.querySelectorAll('.api-search-type')

for (const element of elements) {
  let attributes = element.getAttribute('data-attributes')

  if (attributes) {
    attributes = JSON.parse(attributes)
  }

  const url = element.getAttribute('data-url')

  if (!url) {
    throw new Error('URL is required.')
  }

  const id = element.getAttribute('data-id')
  const name = element.getAttribute('data-name')
  const value = element.getAttribute('data-value')
  const hasErrors = element.hasAttribute('has-errors')

  createApp(Type, {
    id,
    name,
    url,
    attributes,
    value: value ? JSON.parse(value) : null,
    hasErrors,
  }).directive('debounce', vue3Debounce({ lock: true }))
    .mount(element)
}
