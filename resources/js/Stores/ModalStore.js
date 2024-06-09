import {defineStore} from 'pinia'
import {ref} from 'vue'

export const useModalStore = defineStore('modals', () => {
    const openModals = ref([])

    const open = (id) => {
        if (!openModals.value.includes(id)) {
            openModals.value.push(id)
        }
    }

    const close = (id) => {
        openModals.value = openModals.value.filter((modal) => modal !== id)
    }

    return {
        openModals,
        open,
        close,
    }
})
