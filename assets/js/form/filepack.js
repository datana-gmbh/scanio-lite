window.addEventListener('load', function () {
  const $fileNames = document.querySelectorAll('.file-name')
  const $iconsAddLetter = document.querySelectorAll('.file-add-filepack')
  const $submitButton = document.querySelector('button[type="submit"]')
  const $btnMoveAllFilesSeparated = document.querySelector('#btn_move_all_files_separated')
  const $btnMoveAllFilesTogether = document.querySelector('#btn_move_all_files_together')
  const $checkboxForMove = document.querySelectorAll('.checkboxSelectForMove')

  let nextLetter = document.getElementById('filepack_filepackLetters').childElementCount

  $fileNames.forEach(($fileName) =>
    $fileName.addEventListener('click', (e) => handleUpdatePreview(e),
    ))

  $checkboxForMove.forEach(($checkbox) =>
    $checkbox.addEventListener('click', (e) => handleSelectFileForMove(e),
    ),
  )

  $iconsAddLetter.forEach(($icon) =>
    $icon.addEventListener('click', (e) => {
      handleAddLetterClick(e, true)
    },
    ),
  )

  $btnMoveAllFilesSeparated.addEventListener('click', (e) => handleMoveAllFiles(e, true))
  $btnMoveAllFilesTogether.addEventListener('click', (e) => handleMoveAllFiles(e, false))

  // render first file in preview
  function previewNextFile () {
    if (document.querySelector('#filepack_files').childElementCount > 0) {
      return document.querySelector('#filepack_files>div.file > p').click()
    }
  }

  function disableSubmitOnLoad () {
    $submitButton.disabled = true

    return $submitButton.disabled
  }

  function getDomRepresentationOfFileClicked (e) {
    const $files = document.querySelectorAll('.file')

    return Array.from($files).reduce((acc, cv) => {
      if (cv.id === e.target.dataset.fileid) {
        acc = cv
      }

      return acc
    })
  }

  function handleSelectFileForMove (e) {
    target = e.target

    if (target.checked === true) {
      target.parentNode.querySelector('.file-add-filepack').classList.add('selectedForMove')
    } else {
      target.parentNode.querySelector('.file-add-filepack').classList.remove('selectedForMove')
    }
  }

  function handleAddLetterClick (e, separated) {
    const $file = getDomRepresentationOfFileClicked(e)
    const letterId = createLetter($file, separated)

    updateHiddenSelect(letterId)

    const isLetter = $(e.target).closest('.letter').length > 0

    isLetter === true ? updateHiddenSelect($(e.target).closest('.letter').attr('id')) : updateHiddenSelectInbox()

    initializeLists()
    hideEmptyLists()
    previewNextFile()
    checkFormReadyForSubmit()
  }

  function handleMoveAllFiles (e, separated) {
    e.preventDefault()

    const $iconsAddLetterLeft = document.querySelector('#filepack_files').querySelectorAll('.selectedForMove')

    $iconsAddLetterLeft.forEach(($icon) =>
      handleAddLetterClick(e, separated),
    )
  }

  function handleUpdatePreview (e) {
    const path = e.path || (e.composedPath && e.composedPath())

    if (path) {
      window.dispatchEvent(new CustomEvent('pdfexpress.change_document', { detail: path[1].dataset.pdfpath }))
      updateActiveFile(path[1])
    } else {
      // This browser doesn't supply path information
    }
  }

  function checkFormReadyForSubmit () {
    const $filepackFiles = document.getElementById('filepack_files')

    if ($filepackFiles.childElementCount < 1) {
      $submitButton.disabled = false

      return $submitButton.disabled
    }

    $submitButton.disabled = true

    return $submitButton.disabled
  }

  function updateActiveFile (fileClicked) {
    const $files = document.querySelectorAll('.file')

    $files.forEach($file => {
      fileClicked.id === $file.id
        ? $file.classList.add('file-active')
        : $file.classList.remove('file-active')
    })
  }

  // Handle Letter's

  function createElementFromProto (proto, placeholderObj) {
    const toReplace = placeholderObj ? Object.entries(placeholderObj) : []
    let htmlString = proto

    if (toReplace.length > 0) {
      toReplace.forEach(pair => {
        htmlString = htmlString.replaceAll(pair[0], pair[1])
      })
    }

    return $(htmlString)[0]
  }

  function createLetter (item, separated) {
    const $parent = document.getElementById('filepack_filepackLetters')

    let $letter = createElementFromProto($parent.dataset.prototype, { __LETTER_INDEX__: nextLetter })

    if (separated === false) {
      if ($parent.querySelector('.letter') != null) {
        $letter = $parent.querySelector('.letter')
      }
    }

    const letterNumber = getLetterNumber($letter.id)
    const $file = createFile($letter, item, 0, letterNumber, separated)

    nextLetter++
    $letter.querySelector('.files-wrapper').append($file)
    $parent.append($letter)

    return $letter.id
  }

  function createFile ($letter, item, index, separated) {
    const $file = createElementFromProto($letter.querySelector('.files-wrapper').dataset.prototype, {
      __FILE_INDEX__: index,
      __DATA_ID__: item.id,
      __DATA_ORIGINAL_FILENAME__: item.dataset.name,
      __DATA_PDF_PATH__: item.dataset.pdfpath,
    })

    $file.querySelector('.file-name').addEventListener('click', (e) => handleUpdatePreview(e))
    $file.querySelector('.file-add-filepack').addEventListener('click', (e, separated) => handleAddLetterClick(e, separated))
    item.remove()

    return $file
  }

  function appendFile (index, $letter, item) {
    const $fileWrapper = $letter.querySelector('.files-wrapper')
    const fileListLengthBefore = Array.from($fileWrapper.children).length - 1
    const $file = createFile($letter, item, index)

    if (index === 0) {
      $fileWrapper.prepend($file)
    } else if (index === fileListLengthBefore) {
      $fileWrapper.append($file)
    } else {
      $fileWrapper.insertBefore($file, $fileWrapper.childNodes[index])
    }
  }

  function getListDetailsById (listId) {
    const $list = document.getElementById(listId)
    const $files = $list.querySelectorAll('div.file')

    return {
      $list,
      $files,
    }
  }

  function getLetterNumber (letterId) {
    return letterId.split('-').pop()
  }

  function updateHiddenSelect (listId) {
    const letterNumber = getLetterNumber(listId)

    const protoId = `filepack_filepackLetters_${letterNumber}_files___FILE_INDEX__`
    const protoName = `filepack[filepackLetters][${letterNumber}][files][__FILE_INDEX__]`
    const { $files } = getListDetailsById(listId)

    $files.forEach(($file, i) => {
      const $input = $file.querySelector('select.faked-input-hidden')

      $input.name = protoName.replace('__FILE_INDEX__', i.toString())
      $input.id = protoId.replace('__FILE_INDEX__', i.toString())
    })
  }

  function updateHiddenSelectInbox () {
    const protoId = 'filepack_files___FILE_INDEX__'
    const protoName = 'filepack[files][__FILE_INDEX__]'
    const { $files } = getListDetailsById('filepack_files')

    $files.forEach(($file, i) => {
      const $input = $file.querySelector('select.faked-input-hidden')

      $input.name = protoName.replace('__FILE_INDEX__', i.toString())
      $input.id = protoId.replace('__FILE_INDEX__', i.toString())
    })
  }

  function initializeLists () {
    const $lists = document.querySelectorAll('.list')

    $lists.forEach(($elem) =>
      $($elem).sortable({
        dropOnEmpty: true,
        connectWith: '.list',
        receive: (evt, ui) => handleReceive(evt, ui),
      }),
    )
  }

  function hideEmptyLists () {
    const $letters = document.querySelectorAll('.letter')

    $letters.forEach($letter => {
      const letterHasDocuments =
                Array.from($letter.querySelectorAll('div.file')).length > 0

      if (!letterHasDocuments && $letter.id !== 'letter-inbox') {
        $letter.innerHTML = ''
        $letter.style.display = 'none'
      }
    })
  }

  function handleReceive (evt, ui) {
    const filesWrapper = $(ui.item)
    const letter = filesWrapper.closest('.letter')

    if (letter.length > 0) {
      appendFile(ui.item.index(), letter[0], ui.item[0])
      updateHiddenSelect(letter.attr('id'))
    }

    // clear the sender
    const isLetter = $(evt.sender).closest('.letter').length > 0

    isLetter === true ? updateHiddenSelect($(evt.sender).closest('.letter').attr('id')) : updateHiddenSelectInbox()

    checkFormReadyForSubmit()
    previewNextFile()
    hideEmptyLists()
  }

  initializeLists()
  disableSubmitOnLoad()
  checkFormReadyForSubmit()
  previewNextFile()
})
