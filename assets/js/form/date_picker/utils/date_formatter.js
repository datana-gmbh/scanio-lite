import { format, parse } from 'date-fns'
import { de } from 'date-fns/locale'

export function formatDate (date) {
  return format(date, 'dd.MM.yyyy', { locale: de })
}

export function formatDateISO (date) {
  return format(date, 'yyyy-MM-dd')
}

export function stringToDate (string) {
  return parse(string, 'yyyy-MM-dd', new Date())
}
