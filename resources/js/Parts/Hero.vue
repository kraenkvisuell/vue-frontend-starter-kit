<script setup>
import Disruptors from './Hero/Disruptors.vue'
import HeroTitle from './Hero/HeroTitle.vue'
import LargeButton from './Hero/LargeButton.vue'
import Slideshow from './Hero/Slideshow.vue'
import Video from './Hero/Video.vue'
import { useHeaderBarStore } from '../Stores/HeaderBarStore.js'
import { useLinks } from '../Composables/useLinks.js'

const { getLink } = useLinks()

const headerBarStore = useHeaderBarStore()

const props = defineProps({
    entry: {
        type: Object,
        default: {},
    },
    forceShowTitle: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <div
        class="block bg-black"
        :class="{
            'pt-[50px] sm:pt-[56px]': !headerBarStore.headerBarIsVisible,
            'pt-[72px] sm:pt-[78px]': headerBarStore.headerBarIsVisible,
            'h-svh min-h-[400px]': entry.hero_size.value === 'lg',
            'h-[400px]': entry.hero_size.value === 'md' && !headerBarStore.headerBarIsVisible,
            'h-[423px]': entry.hero_size.value === 'md' && headerBarStore.headerBarIsVisible,
            'h-[100px] sm:h-[112px]': entry.hero_size.value === 'sm' && !headerBarStore.headerBarIsVisible,
            'h-[123px] sm:h-[135px]': entry.hero_size.value === 'sm' && headerBarStore.headerBarIsVisible,
        }"
    >
        <div class="h-[100%]">
            <Slideshow v-if="entry.hero_type.value === 'slideshow'" :slides="entry.hero_slideshow" />

            <Video v-else :entry="entry" />

            <div class="h-[100%] max-h-[200px] w-full absolute top-0 left-0 bg-gradient-to-b from-darkest opacity-50" />

            <HeroTitle v-if="entry.show_title || forceShowTitle" :entry="entry" />

            <Disruptors v-if="entry.hero_size !== 'sm'" :entry="entry" />

            <LargeButton v-if="entry.hero_size !== 'sm' && getLink(entry, 'hero_')" :entry="entry" />
        </div>
    </div>
</template>
