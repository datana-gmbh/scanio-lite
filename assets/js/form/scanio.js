(function () {
  const nTimer = setInterval(function () {
    if (window.jQuery) {
      $('.akte-search-widget').each(function (k, v) {
        applyAkteSearchSelect($(v))
      })

      $('.dynamic-dropdown').each(function (k, v) {
        applyDynamicDropdownSelect($(v))
      })

      $('.js-advanced-select-custom').each(function (k, v) {
        $(v).select2(
          {
            closeOnSelect: true,
          },
        )
      })

      clearInterval(nTimer)

      const MutationObserver = window.MutationObserver || window.WebKitMutationObserver

      const observer = new MutationObserver(function (mutations, observer) {
        $.each(mutations, function (k, v) {
          if (v.addedNodes.length > 0) {
            $.each(v.addedNodes, function (ak, av) {
              $.each($(av).find('select.akte-search-widget'), function (sk, sv) {
                applyAkteSearchSelect($(sv))
              })

              $.each($(av).find('.js-advanced-select-custom'), function (sk, sv) {
                $(sv).select2({
                  closeOnSelect: true,
                })
              })

              $.each($(av).find('select.dynamic-dropdown'), function (sk, sv) {
                applyDynamicDropdownSelect($(sv))
              })
            })
          }
        })
      })

      observer.observe(document, {
        subtree: true,
        attributes: false,
        childList: true,
        // ...
      })
    }
  }, 100)
})()

const applyAkteSearchSelect = function (select) {
  select
    .select2({
      minimumInputLength: 1,
      placeholder: 'Bitte Suchbegriff eingeben',
      allowClear: true,
      ajax: {
        delay: 500,
        url: '/akten/find',
        dataType: 'json',
        data: function (params) {
          const ktInstance = select.data('kt-instance') ?? $('select[id$="kt_instance"] option:selected').val() ?? null
          const ktGroup = select.data('kt-group') ?? $('select[id$="kt_group"] option:selected').val() ?? null

          return {
            search_string: params.term,
            kt_instance: ktInstance,
            kt_group: ktGroup,
          }
        },
        processResults: function (data) {
          return {
            results: data,
          }
        },
      },
    })
}

const applyDynamicDropdownSelect = function (select) {
  select
    .select2({
      tags: true,
      allowClear: true,
    })
}
