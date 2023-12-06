window.addEventListener('load', function () {
  const bundesweiteFeiertage = ['2022-01-01', '2022-04-15', '2022-04-18', '2022-05-01', '2022-05-26', '2022-06-06', '2022-10-03', '2022-12-25', '2022-12-26',
    '2023-01-01', '2023-04-07', '2023-04-10', '2023-05-01', '2023-05-18', '2023-05-29', '2023-10-03', '2023-12-25', '2023-12-26',
    '2024-01-01', '2024-03-29', '2024-04-01', '2024-05-01', '2024-05-09', '2024-05-20', '2024-10-03', '2024-12-25', '2024-12-26',
  ]

  $('.uiDatepicker .inputDatepicker').each(function () {
    const altFieldName = $(this).attr('name')
    const altFieldDate = $("[name='" + altFieldName + "']")

    $(this).datepicker({
      firstDay: 1,
      showButtonPanel: true,
      gotoCurrent: true,
      dateFormat: 'dd.mm.yy',
      altFormat: 'yy-mm-dd',
      altField: "[name='" + altFieldName + "'].altDateField",
      changeYear: false,
      yearRange: '-50:+10',
      clickInput: true,
      dayNames: ['Sonntag', 'Montag', 'Dienstag ', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
      monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
      monthNamesShort: ['Jan', 'Feb', 'März', 'Ap', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
      currentText: 'Heute',
      closeText: 'Löschen',
      onClose: function (value) {
        if (!value) {
          $(this).val('')
          altFieldDate.val('')
        }
      },
      beforeShowDay: function (date) {
        const datestring = $.datepicker.formatDate('yy-mm-dd', date)
        const day = date.getDay()

        if (bundesweiteFeiertage.indexOf(datestring) !== -1 || day === 0 || day === 6) {
          return [true, 'holiday']
        }

        return [true]
      },
    })
  })

  $(document).on('click', 'button.ui-datepicker-current', function () {
    $.datepicker._curInst.input.datepicker('setDate', new Date())
    $.datepicker._hideDatepicker()
  })
},
)
