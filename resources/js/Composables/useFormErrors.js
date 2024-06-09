import _ from 'lodash'

export function useFormErrors() {
    function jumpToFirstError(errors, id = null) {
        let scrollContainer = null
        let isBody = false
        if (typeof (id) === 'string' && id) {
            scrollContainer = document.querySelector('#' + id)
        } else {
            scrollContainer = document.querySelector('body')
            isBody = true
        }

        let firstChild = isBody ? document.querySelector('main') : scrollContainer.firstChild
        let innerTop = -firstChild.getBoundingClientRect().top

        let sub = 0
        _.each(errors, (error, name) => {
            let elem = scrollContainer.querySelector('[name="' + name + '"]')
            if (elem) {
                let top = elem.getBoundingClientRect().top
                if (top < sub) {
                    sub = top
                }
            }
        })

        let newPosition = parseInt(innerTop + sub - 130)
        newPosition = newPosition > 0 ? newPosition : 0

        setTimeout(() => {
            if (isBody) {
                scrollTo(0, newPosition)
            } else {
                scrollContainer.scrollTop = newPosition > 0 ? newPosition : 0
            }
        }, 500)

    }

    function getErrorString(errors) {
        return typeof errors === 'object'
            ? Object.values(errors).join('<br>')
            : errors
    }

    function hasErrors(errors) {
        if (typeof errors === 'undefined') return false

        return typeof errors === 'object'
            ? Object.keys(errors).length
            : errors.length
    }

    return { jumpToFirstError, getErrorString, hasErrors }
}
