import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const useHeaderBarStore = defineStore('headerBarStore', () => {
    const website = $shared.globals.website

    const visibleMobileItem = ref(0)

    const headerBarIsVisible = computed(() => {
        return website.header_bar_left.text || website.header_bar_center.text || website.header_bar_right.text
    })

    const mobileItems = computed(() => {
        let items = []

        if (website.header_bar_left.text && website.header_bar_left.text.text) {
            items.push(website.header_bar_left)
        }
        if (website.header_bar_center.text && website.header_bar_center.text.text) {
            items.push(website.header_bar_center)
        }
        if (website.header_bar_right.text && website.header_bar_right.text.text) {
            items.push(website.header_bar_right)
        }

        return items
    })

    const startMobileSlideshow = () => {
        setInterval(() => {
            visibleMobileItem.value++

            if (visibleMobileItem.value >= mobileItems.value.length) {
                visibleMobileItem.value = 0
            }
        }, 3000)
    }

    return {
        website,
        visibleMobileItem,
        headerBarIsVisible,
        mobileItems,
        startMobileSlideshow,
    }
})
