import { defineStore } from 'pinia'
import { ref } from 'vue'

export const usePaneStore = defineStore('panes', () => {
    const openPanes = ref([])

    const open = (id) => {
        if (!openPanes.value.includes(id)) {
            openPanes.value.push(id)
        }
    }

    const close = (id) => {
        openPanes.value = openPanes.value.filter((modal) => modal !== id)
    }

    return {
        openPanes,
        open,
        close,
    }
})
