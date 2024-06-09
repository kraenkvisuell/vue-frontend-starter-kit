import {defineStore} from 'pinia'
import {ref} from 'vue'

export const useZoomStore = defineStore('zoom', () => {
    const isVisible = ref(false)
    const currentImage = ref('')


    const show = (img) => {
        currentImage.value = img
        isVisible.value = true
    }

    const hide = () => {
        currentImage.value = ''
        isVisible.value = false
    }

    return {
        isVisible,
        currentImage,
        show,
        hide,
    }
})
