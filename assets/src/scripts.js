import validate from './utils/validate'

// use WP enqueued jQuery instance
const $ = window.jQuery

$('.js-et-elegant-crm__form').each(elegantForm)

function elegantForm() {
  const $form = $(this)
  $form.attr('novalidate', true) // remove default browser validation
       .on('submit', handleSubmit.bind(this))
}

function handleSubmit(e) {
  e.preventDefault()

  if (!validate(this)) return

  const $form = $(this)
  const data = $form.serialize() + '&action=add_crm_customer'

  $.ajax({
    type: 'POST',
    url: etElegantCrm.ajaxurl,
    data: data,
    success: res => {
      const json = JSON.parse(res)
      $form.html(json.message)
    }
  })
}
