window.addEventListener('load', function () {
  const urlBelegtypFind = '/belegtyp/find'
  const ktInstancesGroups = {
    automotive: ['gara', 'gebührenklage'],
    banking: ['502', 'akw', 'Gebührenerstattung'],
    cola: ['BSV', 'Corona'],
    rsv: ['RSV Eskalation'],
  }

  $('.js_kt_instance').change(function (e) {
    ktInstance = e.target.value
    letterId = $('.js_letter').val()
    filepackId = $('.js_filepack').val()

    changeKtGroup(ktInstance)
    changeBelegtypOptions(ktInstance, $('.js_kt_group').val(), letterId, filepackId)
  })
  $('.js_kt_group').change(function (e) {
    ktGroup = e.target.value
    letterId = $('.js_letter').val()
    filepackId = $('.js_filepack').val()
    changeBelegtypOptions($('.js_kt_instance').val(), ktGroup, letterId, filepackId)
  })

  const changeKtGroup = function (ktInstance) {
    if (ktInstance) {
      $('.js_kt_group').empty()
      ktInstancesGroups[ktInstance].forEach(element =>
        $('.js_kt_group').append($('<option></option>').attr('value', element).text(element)),
      )
    }
  }

  const changeBelegtypOptions = function (ktInstance, ktGroup, letterId, filepackId) {
    if (ktInstance && ktGroup && (letterId || filepackId)) {
      $.ajax({
        url: urlBelegtypFind,
        type: 'get',
        dataType: 'json',
        data: { kt_instance: ktInstance, kt_group: ktGroup, letter: letterId, filepack: filepackId },
        success: function (data) {
          $('.js_belegtyp').empty()

          for (const [text, value] of Object.entries(data)) {
            $('.js_belegtyp').append($('<option></option>').attr('value', value).text(text))
          }

          // change prototype, if exist
          const containerPrototype = document.querySelector('.js_contains_belegtypen')

          if (containerPrototype != null) {
            const prototype = containerPrototype.dataset.prototype
            const prototypeElement = $(prototype)
            const belegtypDropdown = prototypeElement.find('.js_belegtyp')
            const newBelegtypDropdown = belegtypDropdown.clone()

            newBelegtypDropdown.empty()

            for (const [text, value] of Object.entries(data)) {
              newBelegtypDropdown.append($('<option></option>').attr('value', value).text(text))
            }
            belegtypDropdown.replaceWith(newBelegtypDropdown)
            containerPrototype.dataset.prototype = prototypeElement.get(0).outerHTML
          }
        },
        cache: false,
      }).fail(function (jqXHR, textStatus, error) {
        console.log('Fehler:' + error)
      })
    }
  }

  // for splitting
  $('.js_belegtyp_nested_form .nested-form__add-btn').click(function (e) {
    changeBelegtypOptions($('.js_kt_instance').val(), $('.js_kt_group').val(), $('.js_letter').val(), $('.js_filepack').val())
  })

  $('.js_belegtyp').empty()
  changeKtGroup($('.js_kt_instance').val())
  changeBelegtypOptions($('.js_kt_instance').val(), $('.js_kt_group').val(), $('.js_letter').val(), $('.js_filepack').val())
})
