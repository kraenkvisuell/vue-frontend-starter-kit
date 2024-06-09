<script setup>
import { useMedia } from '../../../Composables/useMedia.js'
import { computed, ref } from 'vue'

const { imageLink } = useMedia()

const props = defineProps({
    slide: { type: Object, default: {} },
    index: Number,
})

const qualityIsVisible = ref(false)

setTimeout(() => qualityIsVisible.value = true, 2000)

const phoneImage = computed(() => props.slide.image_phone ? props.slide.image_phone : props.slide.image_desktop)
const desktopImage = computed(() => props.slide.image_desktop ? props.slide.image_desktop : props.slide.image_phone)

</script>

<template>
    <div class="h-full w-full">

        <picture class="h-full w-full absolute inset-0">
            <source
                :srcset="imageLink(desktopImage, { crop: true, fit: [240, 180], output: 'preview' })"
                media="(orientation: landscape)"
            />

            <img
                :src="imageLink(phoneImage, {crop: true, fit: [60, 90], output: 'preview'})"
                :alt="slide.alt"
                :fetchpriority="index ? 'low' : 'high'"
                class="h-full w-full object-cover"
            />
        </picture>


        <picture
            class="h-full w-full transition-opacity duration-700"
            :class="{
                'opacity-0': !qualityIsVisible,
                'opacity-full': qualityIsVisible,
            }"
        >
            <source
                :srcset="imageLink(desktopImage, { crop: true, fit: [2400, 1800], quality: 65 })"
                media="(min-width: 1024px) and (orientation: landscape)"
            />

            <source
                :srcset="imageLink(phoneImage, { crop: true, fit: [1800, 2400], quality: 65 })"
                media="(min-width: 768px) and (orientation: portrait)"
            />

            <source
                :srcset="imageLink(desktopImage, { crop: true, fit: [2000, 1500], quality: 65 })"
                media="(min-width: 768px) and (orientation: landscape)"
            />

            <source
                :srcset="imageLink(phoneImage, { crop: true, fit: [1500, 2000], quality: 65 })"
                media="(min-width: 768px) and (orientation: portrait)"
            />

            <source
                :srcset="imageLink(phoneImage, { crop: true, fit: [900, 1200], quality: 65 })"
                media="(min-width: 512px) and (orientation: portrait)"
            />

            <source
                :srcset="imageLink(desktopImage, { crop: true, fit: [1200, 900], quality: 65 })"
                media="(orientation: landscape)"
            />

            <img
                :src="imageLink(phoneImage, {crop: true, fit: [600, 900], quality: 65})"
                :alt="slide.alt"
                :fetchpriority="index ? 'low' : 'high'"
                class="h-full w-full object-cover"
            />
        </picture>

    </div>
</template>
