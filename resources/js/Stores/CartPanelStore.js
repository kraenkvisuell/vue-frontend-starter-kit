import {defineStore} from 'pinia'
import {ref} from 'vue'

export const useCartPanelStore = defineStore('cartPanelStore', () => {

    const isOpen = ref(false)

    const toggle = () => {
        isOpen.value = !isOpen.value
    }
    const close = () => {
        isOpen.value = false
    }

    return {
        isOpen,
        toggle,
        close,
    }
})
