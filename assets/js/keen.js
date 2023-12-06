window.addEventListener('load', function () {
  $('.js_ergebnis').change(function (e) {
    ergebnisSelected = e.target.value
    showHideByErgebnis(ergebnisSelected)
  })

  const showHideByErgebnis = function (ergebnis) {
    if (ergebnis === 'Teilobsiegen') {
      $('.inputDatepicker.js_datum_deckungszusage_erstritten').removeClass('hidden')
      $('.js_label_datum_deckungszusage_erstritten').removeClass('hidden')
      $('.js_checkbox_deckungszusage_zugesprochen').removeClass('hidden')
    } else {
      hideAndUnset($('.js_datum_deckungszusage_erstritten'))
      hideAndUnsetCheckbox($('.js_checkbox_deckungszusage_zugesprochen'))
    }
  }

  const hideAndUnsetCheckbox = function (containerEl) {
    containerEl.addClass('hidden')
    checkbox = containerEl.find(':checkbox')
    checkbox.prop('checked', false)
  }

  const hideAndUnset = function (inputField) {
    inputField.addClass('hidden')
    inputField.val('')
  }

  showHideByErgebnis($('.js_ergebnis').val())
})
