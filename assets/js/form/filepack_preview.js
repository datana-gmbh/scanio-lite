window.addEventListener('load', function () {
  const $fileNames = document.querySelectorAll('.file-name')

  $fileNames.forEach(($fileName) =>
    $fileName.addEventListener('click', (e) => handleUpdatePreview(e),
    ))

  // render first file in preview
  function previewNextFile () {
    if (document.querySelector('#filepack_files').childElementCount > 0) {
      return document.querySelector('#filepack_files>div.file > p').click()
    }
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

  function updateActiveFile (fileClicked) {
    const $files = document.querySelectorAll('.file')

    $files.forEach($file => {
      fileClicked.id === $file.id
        ? $file.classList.add('file-active')
        : $file.classList.remove('file-active')
    })
  }

  previewNextFile()
})
