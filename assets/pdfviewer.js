import WebViewer from '@pdftron/pdfjs-express-viewer'

(() => {
  const element = document.getElementById('pdfviewer')

  if (!element) {
    return
  }

  WebViewer({
    path: '/build/pdfviewer',
    licenseKey: 'KzQGk6V6PwH3VE6AmQZ5',
    initialDoc: element.getAttribute('data-file-path'),
    css: '/build/pdfviewer/css/_overrides.css',
  },
  element,
  ).then(instance => {
    window.addEventListener('pdfexpress.change_document', event => {
      instance.UI.loadDocument(event.detail)
    })
  })
})()
