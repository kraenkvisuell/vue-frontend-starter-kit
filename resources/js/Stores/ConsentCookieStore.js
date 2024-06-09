import Cookies from 'js-cookie'
import _ from 'lodash'
import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const useConsentCookieStore = defineStore('consentCookieStore', () => {
    const selectedConsentGroups = ref([])
    const readonlyConsentGroups = ref([])
    const isBusy = ref(false)

    const hasSetCookieConsent = computed(() => {
        return Cookies.get('has_set_cookie_consent')
    })

    const consentGroupOptions = computed(() => {
        let options = []

        _.forEach($shared.cookieConsentGroups, function(consentGroup) {
            options.push({
                value: consentGroup.slug,
                label: consentGroup.title,
            })
        })

        return options
    })

    const setHasConsented = () => {
        Cookies.set('has_set_cookie_consent', true, { expires: 365 })
    }

    const init = () => {
        _.forEach($shared.cookieConsentGroups, function(consentGroup) {
            if (!consentGroup.can_be_deactivated) {
                readonlyConsentGroups.value.push(consentGroup.slug)
            }

            selectedConsentGroups.value.push(consentGroup.slug)
        })
    }

    const submit = (method) => {
        isBusy.value = true

        setHasConsented()

        let hasConsentedTo = []

        _.forEach($shared.cookieConsentGroups, function(consentGroup) {
            if (method === 'agree' || (method === 'save' && selectedConsentGroups.value.indexOf(consentGroup.slug) > -1)) {
                hasConsentedTo.push(consentGroup.slug)
            }
        })

        Cookies.set('has_consented_to', hasConsentedTo, { expires: 365 })

        location.reload()
    }

    const addToConsentedTo = (slug) => {
        const str = Cookies.get('has_consented_to') ? Cookies.get('has_consented_to') : ''
        const arr = str.split(',')

        if (arr.indexOf(slug) === -1) {
            arr.push(slug)
        }

        Cookies.set('has_consented_to', arr, { expires: 365 })
    }

    const hasConsentedTo = (slug) => {
        const str = Cookies.get('has_consented_to') ? Cookies.get('has_consented_to') : ''

        const arr = str.split(',')

        return arr.indexOf(slug) > -1
    }

    return {
        selectedConsentGroups,
        readonlyConsentGroups,
        isBusy,
        hasSetCookieConsent,
        consentGroupOptions,
        setHasConsented,
        init,
        submit,
        hasConsentedTo,
        addToConsentedTo,
    }
})
