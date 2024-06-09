<script setup>
import Slide from './Slideshow/Slide.vue'
import { onMounted, ref } from 'vue'

const props = defineProps({
    slides: {
        type: Array,
        default: [],
    },
})

let currentSlide = ref(0)

const switchSlide = () => (
    currentSlide.value = currentSlide.value < props.slides.length - 1
        ? currentSlide.value + 1
        : 0
)

onMounted(() => {
    if (props.slides.length > 1) {
        setInterval(() => switchSlide(), 4000)
    }
})
</script>

<template>
    <div class="h-full w-full">
        <div
            v-for="(slide, index) in slides"
            class="absolute inset-0 h-full w-full transition-opacity duration-[1500ms]"
            :class="{
                'opacity-0': currentSlide !== index,
                'opacity-full': currentSlide === index,
            }"
        >
            <Slide :slide="slide" :index="index" />
        </div>
    </div>
</template>
