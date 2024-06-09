<script setup>
import MagnifyingGlass from '../../../Parts/Menu/Search/MagnifyingGlass.vue'
import { useMedia } from '../../../Composables/useMedia.js'
import { useZoomStore } from '../../../Stores/ZoomStore.js'

const { imageLink } = useMedia()

const zoomStore = useZoomStore()

const props = defineProps({
    image: Object,
})

</script>

<template>
    <div class="hidden md:block absolute bottom-0 right-0">
        <button
            @click="zoomStore.show(imageLink(image, {width: 1400}))"
            class="
                text-gray-300 hover:text-gray-400 cursor-pointer flex items-center justify-center px-[20px] py-[12px]
            "
        >
            <div class="h-icon flex">
                <MagnifyingGlass />
            </div>
        </button>
    </div>
</template>
