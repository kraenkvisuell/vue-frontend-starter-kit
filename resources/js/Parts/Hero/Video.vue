<script setup>
import { computed } from 'vue'
import { useMedia } from '../../Composables/useMedia.js'

const { fileLink } = useMedia()

const props = defineProps({
    entry: {
        type: Object,
        default: {},
    },
})

let phoneVideo = computed(() => props.entry.hero_video_phone ? props.entry.hero_video_phone : props.entry.hero_video_desktop)
let desktopVideo = computed(() => props.entry.hero_video_desktop ? props.entry.hero_video_desktop : props.entry.hero_video_phone)

let fallbackPhoneVideo = computed(() => {
    return props.entry.hero_fallback_video_phone
        ? props.entry.hero_fallback_video_phone
        : props.entry.hero_fallback_video_desktop
})

let fallbackDesktopVideo = computed(() => {
    return props.entry.hero_fallback_video_desktop
        ? props.entry.hero_fallback_video_desktop
        : props.entry.hero_fallback_video_phone
})
</script>


<template>
    <video
        v-if="phoneVideo"
        class="landscape:hidden h-full w-full object-cover"
        playsinline muted autoplay loop
    >
        <source :src="fileLink(phoneVideo)" :type="phoneVideo.mime_type" />

        <source
            v-if="fallbackPhoneVideo && fallbackPhoneVideo.mime_type !== phoneVideo.mime_type"
            :src="fileLink(fallbackPhoneVideo)"
            :type="fallbackPhoneVideo.mime_type"
        />
    </video>

    <video
        v-if="desktopVideo"
        class="landscape:block hidden h-full w-full object-cover"
        playsinline muted autoplay loop
    >
        <source :src="fileLink(desktopVideo)" :type="desktopVideo.mime_type" />

        <source
            v-if="fallbackDesktopVideo && fallbackDesktopVideo.mime_type !== phoneVideo.mime_type"
            :src="fileLink(fallbackDesktopVideo)"
            :type="fallbackDesktopVideo.mime_type"
        />
    </video>
</template>
