<script setup>
import { useMedia } from '../../Composables/useMedia.js'
import { useProductStore } from '../../Stores/ProductStore.js'
import { useZoomGalleryStore } from '../../Stores/ZoomGalleryStore.js'

const { imageLink, videoLink } = useMedia()

const zoomGalleryStore = useZoomGalleryStore()

const productStore = useProductStore()

const props = defineProps({
    image: Object,
    imageIndex: Number,
})
</script>

<template>
    <button
        @click="zoomGalleryStore.show(productStore.currentDetailImages, imageIndex)"
        :title="image.perspective"
        class="block w-[70px] h-[70px] @md:w-[80px] @md:h-[80px]  @lg:w-[90px] @lg:h-[90px]"
    >
        <picture v-if="image.is_image">
            <img
                :src="imageLink(image, {width: 200})"
                class="h-full w-full object-contain"
                loading="lazy"
            />
        </picture>

        <video
            v-if="image.is_video"
            class="h-full w-full object-cover"
            playsinline muted
            preload="metadata"
        >
            <source :src="videoLink(image)+'#t=1'" :type="image.mime_type" />
        </video>

        <span v-if="image.is_video" class="absolute inset-0 w-full h-full flex items-center justify-center">
            <span
                class="
                    absolute bottom-[3px] right-[3px] flex justify-center items-center
                    rounded-full w-[24px] h-[24px] bg-highlight text-white
                "
            >
                <i class="ml-[2px] fa-solid fa-play text-[12px]"></i>
            </span>
        </span>
    </button>
</template>
