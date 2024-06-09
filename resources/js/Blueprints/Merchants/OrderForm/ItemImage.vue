<script setup>
import { useMedia } from '../../../Composables/useMedia.js'

const { imageLink, fileLink } = useMedia()

const props = defineProps({
    image: Object,
})
</script>

<template>
    <div class="w-[70px] h-[70px] p-[5px]">
        <picture v-if="image.is_image">
            <img
                :src="imageLink(image, {width: 140})"
                class="w-[60px] h-[60px] object-contain rounded"
                loading="lazy"
            />
        </picture>

        <video
            v-if="image.is_video"
            class="w-[60px] h-[60px] object-cover rounded"
            playsinline muted autoplay loop
        >
            <source :src="fileLink(image)" :type="image.mime_type" />
        </video>
    </div>
</template>
