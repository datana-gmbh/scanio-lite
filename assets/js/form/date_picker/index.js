import Type from './components/DatePickerType.vue'
import { createApp } from 'vue'

const elements = document.querySelectorAll('.date-picker-type')

for (const element of elements) {
  let attributes = element.getAttribute('data-attributes')

  if (attributes) {
    attributes = JSON.parse(attributes)
  }

  const id = element.getAttribute('data-id')
  const name = element.getAttribute('data-name')
  const value = element.getAttribute('data-value')
  const hasErrors = element.hasAttribute('has-errors')

  createApp(Type, {
    id,
    name,
    attributes,
    value,
    hasErrors,
  }).mount(element)
}
