/**
 * Example:
 *
 * <div>
 *     <span class="toggle-hidden" data-target="#some-id">
 *         Click me!
 *     </span>
 *     <div id="some-id">
 *         <!-- This element will be toggled -->
 *     </div>
 * </div>
 */
(() => {
  document.querySelectorAll('.toggle-hidden').forEach(element => {
    const target = document.querySelector(element.getAttribute('data-target'))

    element.addEventListener('click', event => {
      event.preventDefault()
      event.stopImmediatePropagation()

      if (target.classList.contains('hidden')) {
        target.classList.remove('hidden')
      } else {
        target.classList.add('hidden')
      }
    })
  })
})()
