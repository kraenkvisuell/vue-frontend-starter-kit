import {defineStore} from 'pinia'
import {ref} from 'vue'

export const useZoomGalleryStore = defineStore('zoomGalleryStore', () => {
    const isVisible = ref(false)
    const slides = ref([])
    const currentIndex = ref(0)

    const show = (newSlides, index) => {
        slides.value = newSlides
        isVisible.value = true
        currentIndex.value = index
    }

    const hide = () => {
        slides.value = []
        isVisible.value = false
    }

    return {
        currentIndex,
        isVisible,
        slides,
        show,
        hide,
    }
})
