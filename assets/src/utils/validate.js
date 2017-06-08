export default function validate (form) {
  const requiredFields = form.querySelectorAll('[required]')
  const emailFields = form.querySelectorAll('[type=email]')
  const pipe = (...args) => field => args.forEach(arg => arg(field))
  const isEmptyField = field => field.value.length == 0
  const isNotEmail = field => !~field.value.indexOf('@') || !~field.value.indexOf('.') || field.value.length < 6
  const addErrorClass = field => field.classList.add('is-error')
  const removeErrorClass = field => field.classList.remove('is-error')
  const removeErrorClassOnKeydown = field => field.addEventListener('keydown', () => removeErrorClass(field))

  const invalidFields =
    new Set([
      ...Array.from(requiredFields).filter(isEmptyField),
      ...Array.from(emailFields).filter(isNotEmail)
    ])

  invalidFields.forEach(pipe(
    addErrorClass,
    removeErrorClassOnKeydown
  ))

  return (invalidFields.length) ? false : true
}
