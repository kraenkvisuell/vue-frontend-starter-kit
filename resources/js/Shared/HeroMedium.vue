<script setup>
import { useMedia } from '../Composables/useMedia.js'

const { imageLink, fileLink } = useMedia()

const props = defineProps({
    type: { type: String, default: 'file' },
    file: { type: Object, default: null },
    alt: { type: String, default: '' },
    objectFit: { type: String, default: 'object-cover' },
})
</script>

<template>
    <template v-if="type === 'file' && file">
        <picture v-if="file.is_image">
            <source
                media="(min-width: 1440px)"
                :srcset="imageLink(file, {width: 2400})" :type="file.mime_type"
            >

            <source
                media="(min-width: 728px)"
                :srcset="imageLink(file, {width: 1400})" :type="file.mime_type"
            >

            <img
                :src="imageLink(file, {width: 1000})"
                :alt="alt"
                loading="lazy"
                class="w-full h-full"
                :class="[objectFit]"
            />
        </picture>

        <video
            v-if="file.is_video"
            class="h-full w-full object-cover"
            playsinline muted autoplay loop
        >
            <source :src="fileLink(file)" :type="file.mime_type" />
        </video>
    </template>
</template>
