window.addEventListener('load', function () {
  // Deckungszusage
  const $zusageAussergerichtlichUndGerichtlich = [
    'Außergerichtlich',
    'Gerichtlich (I. Instanz)',
    'Gerichtlich aber außergerichtlich abgelehnt',
    'Gerichtlich aber Abwehrdeckung außergerichtlich',
    'Gerichtlich und außergerichtlich',
    'Gerichtlich und außergerichtlich und Berufung',
  ]

  const $deckungszusageBerufung = [
    'Berufung vollständig (II. Instanz)',
    'Berufung nur Einlegung (II. Instanz)',
    'Berufung nur Anschlussberufung (II. Instanz)',
    'Berufung nur Verteidigung (II. Instanz)',
  ]

  const $zusageAberStichentscheid = 'Zusage Hauptsache aber Ablehnung Stichentscheid'
  const $deckungszusageStichentscheid = 'Stichentscheid'
  const $deckungszusageVergleich = 'Vergleich'
  const $deckungszusage = 'Deckungszusage'
  const $bedingungVorhanden = 'Bedingung vorhanden'

  $('.js_art_der_zusage').change(function (e) {
    artDerZusageSelected = e.target.value
    showHideDeckungszusageNachfragen(artDerZusageSelected, $('.js_art_deckungszusage').val())
  })

  $('.js_art_deckungszusage').change(function (e) {
    artDeckungszusageSelected = e.target.value
    showHideDeckungszusageNachfragen($('.js_art_der_zusage').val(), artDeckungszusageSelected)
  })

  $('.js_is_bedingung_vorhanden').change(function (e) {
    bedingungVorhandenSelected = e.target.value
    showHideBedingungen(bedingungVorhandenSelected)
    showHideDifferenzschaden(bedingungVorhandenSelected)
  })

  const hideAndUnsetCheckboxes = function (containerEl) {
    containerEl.addClass('hidden')
    checkboxes = containerEl.find(':checkbox')
    checkboxes.prop('checked', false)
  }

  const showHideDeckungszusageNachfragen = function (artDerZusage, artDerDeckungszusage) {
    if (isDeckungszusageStichentscheidOderVergleichSelected(artDerZusage) || artDerDeckungszusage === $zusageAberStichentscheid) {
      $('.js_nachfragen_optional_1').removeClass('hidden')
      $('.js_nachfragen_optional_2').removeClass('hidden')
    } else if (isDeckungszusageAussergerichtlichOrGerichtlich(artDerDeckungszusage) && artDerZusage === $deckungszusage) {
      $('.js_nachfragen_optional_1').removeClass('hidden')
      hideAndUnsetCheckboxes($('.js_nachfragen_optional_2'))
    } else if (isDeckungszusageBerufung(artDerDeckungszusage) && artDerZusage === $deckungszusage) {
      hideAndUnsetCheckboxes($('.js_nachfragen_optional_1'))
      $('.js_nachfragen_optional_2').removeClass('hidden')
    } else {
      hideAndUnsetCheckboxes($('.js_nachfragen_optional_1'))
      hideAndUnsetCheckboxes($('.js_nachfragen_optional_2'))
    }
  }

  const showHideBedingungen = function (bedingungVorhanden) {
    if ($bedingungVorhanden === bedingungVorhanden) {
      $('.js_bedingungen').removeClass('hidden')
    } else {
      hideAndUnsetCheckboxes($('.js_bedingungen'))
    }
  }

  const showHideDifferenzschaden = function (bedingungVorhanden) {
    if ($bedingungVorhanden === bedingungVorhanden) {
      $('.js_differenzschaden').removeClass('hidden')
    } else {
      $('.js_differenzschaden').addClass('hidden').prop('selectedIndex', 0)
    }
  }

  const isDeckungszusageStichentscheidOderVergleichSelected = function (artDerZusage) {
    return $deckungszusageStichentscheid === artDerZusage || $deckungszusageVergleich === artDerZusage
  }

  const isDeckungszusageAussergerichtlichOrGerichtlich = function (artDerDeckungszusage) {
    return artDerDeckungszusage !== 'undefined' && $.inArray(artDerDeckungszusage, $zusageAussergerichtlichUndGerichtlich) > -1
  }

  const isDeckungszusageBerufung = function (artDerDeckungszusage) {
    return artDerDeckungszusage !== 'undefined' && $.inArray(artDerDeckungszusage, $deckungszusageBerufung) > -1
  }

  showHideDeckungszusageNachfragen($('.js_art_der_zusage').val(), $('.js_art_deckungszusage').val())
  showHideBedingungen($('.js_is_bedingung_vorhanden').val())
  showHideDifferenzschaden($('.js_is_bedingung_vorhanden').val())

  // Deckungsablehnung

  const $ablehnungUmfangAussergerichtlichUndGerichtlich = [
    'Außergerichtlich',
    'Gerichtlich',
    'Gerichtlich und außergerichtlich',
  ]

  const $ablehnungUmfangBerufung = 'Berufung'
  const $deckungsablehnungAblehnung = 'Deckungsablehnung'
  const $deckungsablehnungStichentscheid = 'Stichentscheid'

  const isDeckungsablehnungUmfangAussergerichtlichOrGerichtlich = function (umfangDerAblehnung) {
    return umfangDerAblehnung !== 'undefined' && $.inArray(umfangDerAblehnung, $ablehnungUmfangAussergerichtlichUndGerichtlich) > -1
  }

  const isDeckungsablehnungUmfangBerufung = function (artUmfangAblehnung) {
    return artUmfangAblehnung !== 'undefined' && artUmfangAblehnung === $ablehnungUmfangBerufung
  }

  const showHideAblehnungsgruenden = function (artDeckungsablehnung, artUmfangDeckungsablehnung) {
    if (artDeckungsablehnung === $deckungsablehnungAblehnung) {
      $('.js_ablehnungsgruende_deckungsablehnung').removeClass('hidden')
      hideAndUnsetCheckboxes($('.js_ablehnungsgruende_stichentscheid'))

      if (isDeckungsablehnungUmfangAussergerichtlichOrGerichtlich(artUmfangDeckungsablehnung)) {
        $('.js_ablehnungsgruende_gerichtlich_aussergerichtlich').removeClass('hidden')
        hideAndUnsetCheckboxes($('.js_ablehnungsgruende_berufung'))
      } else if (isDeckungsablehnungUmfangBerufung(artUmfangDeckungsablehnung)) {
        hideAndUnsetCheckboxes($('.js_ablehnungsgruende_gerichtlich_aussergerichtlich'))
        $('.js_ablehnungsgruende_berufung').removeClass('hidden')
      } else {
        hideAndUnsetCheckboxes($('.js_ablehnungsgruende_gerichtlich_aussergerichtlich'))
        hideAndUnsetCheckboxes($('.js_ablehnungsgruende_berufung'))
      }
    } else if (artDeckungsablehnung === $deckungsablehnungStichentscheid) {
      $('.js_ablehnungsgruende_stichentscheid').removeClass('hidden')

      hideAndUnsetCheckboxes($('.js_ablehnungsgruende_deckungsablehnung'))
      hideAndUnsetCheckboxes($('.js_ablehnungsgruende_berufung'))
      hideAndUnsetCheckboxes($('.js_ablehnungsgruende_gerichtlich_aussergerichtlich'))
    } else {
      hideAndUnsetCheckboxes($('.js_ablehnungsgruende'))
    }
  }

  const showHideKostenSchiedsgutachten = function (schiedsgutachtenSelected) {
    if (schiedsgutachtenSelected === 'RSV übernimmt Kosten nur bei positivem Ergebnis Schiedsgutachten') {
      $('.js_kosten_schiedsgutachten_laut_rsv').removeClass('hidden')
    } else {
      $('.js_kosten_schiedsgutachten_laut_rsv').val(null)
      $('.js_kosten_schiedsgutachten_laut_rsv').addClass('hidden')
    }
  }

  $('.js_art_der_ablehnung').change(function (e) {
    artDerAblehnungSelected = e.target.value
    showHideAblehnungsgruenden(artDerAblehnungSelected, $('.js_umfang_deckungsablehnung').val())
  })

  $('.js_umfang_deckungsablehnung').change(function (e) {
    umfangAblehnungSelected = e.target.value
    showHideAblehnungsgruenden($('.js_art_der_ablehnung').val(), umfangAblehnungSelected)
  })

  $('.js_schiedsgutachten').change(function (e) {
    schiedsgutachtenSelected = e.target.value
    showHideKostenSchiedsgutachten(schiedsgutachtenSelected)
  })

  showHideAblehnungsgruenden($('.js_art_der_ablehnung').val(), $('.js_umfang_deckungsablehnung').val())
  showHideKostenSchiedsgutachten($('.js_schiedsgutachten').val())

  // Kosten
  const $kostenArtDesSchreibens = [
    'Kostennote', 'Kostennote Nachfragen', 'Kostennote und Gerichtskosten Zahlungsbestätigung',
  ]

  const showHideKostenNichtzahlungsgruende = function (artDesSchreibens) {
    if (artDesSchreibens !== 'undefined' && $.inArray(artDesSchreibens, $kostenArtDesSchreibens) > -1) {
      $('.js_kosten_nichtzahlungsgruende').removeClass('hidden')
    } else {
      hideAndUnsetCheckboxes($('.js_kosten_nichtzahlungsgruende'))
    }
  }

  const showHideKostenKostennote = function (artDesSchreibens) {
    if (artDesSchreibens !== 'undefined' && $.inArray(artDesSchreibens, $kostenArtDesSchreibens) > -1) {
      $('.js_kosten_kostennote').removeClass('hidden')
    } else {
      hideAndUnsetCheckboxes($('.js_kosten_kostennote'))
    }
  }

  const showHideGerichtskostenNachfragen = function (artDesSchreibens) {
    if (artDesSchreibens !== 'undefined' && artDesSchreibens === 'Gerichtskosten Nachfrage') {
      $('.js_kosten_gerichtskosten_nachfragen').removeClass('hidden')
    } else {
      hideAndUnsetCheckboxes($('.js_kosten_gerichtskosten_nachfragen'))
    }
  }

  const showHideKostennoteGerichtskostenBestaetigung = function (artDesSchreibens) {
    if (artDesSchreibens !== 'undefined' && artDesSchreibens === 'Kostennote und Gerichtskosten Zahlungsbestätigung') {
      $('.js_kostennote_gerichtskosten_bestaetigung').removeClass('hidden')
    } else {
      hideAndUnsetCheckboxes($('.js_kostennote_gerichtskosten_bestaetigung'))
    }
  }

  const showHideKostenByArtDesSchreibens = function (artDesSchreibens) {
    showHideKostenNichtzahlungsgruende(artDesSchreibens)
    showHideKostenKostennote(artDesSchreibens)
    showHideGerichtskostenNachfragen(artDesSchreibens)
    showHideKostennoteGerichtskostenBestaetigung(artDesSchreibens)
  }

  const showHideByDringendeAngelegenheit = function (dringendeAngelegenheit, artDesSchreibens) {
    if (dringendeAngelegenheit !== 'undefined' && dringendeAngelegenheit === true) {
      hideAndUnsetCheckboxes($('.js_kosten'))
    } else {
      showHideKostenByArtDesSchreibens(artDesSchreibens)
    }
  }

  $('.js_kosten_art_des_schreibens').change(function (e) {
    // dringende Angelegenheit hat immer Vorrang
    showHideByDringendeAngelegenheit($('.js_dringende_angelegenheit').is(':checked'), e.target.value)
  })

  $('.js_dringende_angelegenheit').change(function (e) {
    showHideByDringendeAngelegenheit($('.js_dringende_angelegenheit').is(':checked'), $('.js_kosten_art_des_schreibens').val())
  })

  showHideByDringendeAngelegenheit($('.js_dringende_angelegenheit').is(':checked'), $('.js_kosten_art_des_schreibens').val())
})
