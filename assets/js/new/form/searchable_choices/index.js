import Type from './components/SearchableChoicesType.vue'
import { createApp } from 'vue'

const elements = document.querySelectorAll('.searchable-choices-type')

for (const element of elements) {
  let attributes = element.getAttribute('data-attributes')

  if (attributes) {
    attributes = JSON.parse(attributes)
  }

  let choices = element.getAttribute('data-choices')

  if (choices) {
    choices = JSON.parse(choices)
  }

  const id = element.getAttribute('data-id')
  const name = element.getAttribute('data-name')
  const value = element.getAttribute('data-value')

  const hasErrors = element.hasAttribute('has-errors')

  createApp(Type, {
    id,
    name,
    attributes,
    choices,
    value,
    hasErrors,
  }).mount(element)
}
