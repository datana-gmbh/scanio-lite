/**
 * Example:
 *
 * <div>
 *     <span class="collapsible">
 *         Click me!
 *         <svg class="toggle-icon">
 *             ...
 *         </svg>
 *     </span>
 *     <div>
 *         <!-- This element will be toggled -->
 *     </div>
 * </div>
 */
(() => {
  document.querySelectorAll('.collapsible').forEach(element => {
    const svg = element.querySelector('svg.toggle-icon')
    const target = element.nextElementSibling

    element.addEventListener('click', event => {
      event.preventDefault()
      event.stopImmediatePropagation()

      if (target.classList.contains('invisible-transition')) {
        // to get the natural height of that element without side effects
        target.style.height = 'auto'
        target.style.height = `${target.scrollHeight}px`
        target.classList.replace('invisible-transition', 'visible-transition')
      } else {
        target.style.height = '0'
        target.classList.replace('visible-transition', 'invisible-transition')
      }

      svg?.classList.toggle('-rotate-90')
    })
  })
})()
