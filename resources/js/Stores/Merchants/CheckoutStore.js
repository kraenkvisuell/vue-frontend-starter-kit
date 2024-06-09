import {defineStore} from 'pinia'
import {ref} from 'vue'
import {useScroll} from '../../Composables/useScroll.js'

export const useCheckoutStore = defineStore('checkoutStore', () => {
    const {scrollToTop} = useScroll()
    const addressFormIsOpen = ref(false)

    const closeAddressForm = () => {
        addressFormIsOpen.value = false
        scrollToTop()
    }

    const openAddressForm = () => {
        addressFormIsOpen.value = true
        scrollToTop()
    }

    return {addressFormIsOpen, closeAddressForm, openAddressForm}
})
