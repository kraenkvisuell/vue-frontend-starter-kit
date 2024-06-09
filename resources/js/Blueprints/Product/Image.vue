<script setup>
import { useMedia } from '../../Composables/useMedia.js';
import AnimatedImage from '../../Shared/AnimatedImage.vue';
import { computed, ref } from 'vue';

const { imageLink, videoLink } = useMedia();

const props = defineProps({
    image: Object,
    sku: { type: Object, default: null },
    alt: { type: String, default: '' },
    selectedSkuId: { type: Number, default: 0 }
});

const parentImage = ref(null);

let isSelected = computed(() => props.selectedSkuId === props.sku.id);

</script>

<template>
    <div v-if="image" class="w-full h-full flex items-center justify-center">
        <picture v-if="image.is_image">
            <img
                :src="imageLink(image, {width: 1000})"
                :alt="alt"
                class="h-[90%] w-[90%] object-contain"
                ref="parentImage"
            />
        </picture>

        <video
            v-if="image.is_video"
            class="h-full w-full object-cover"
            playsinline muted autoplay loop
        >
            <source :src="videoLink(image)" :type="image.mime_type" />
        </video>
    </div>

    <AnimatedImage v-if="sku && !image.is_video" :parentImage="parentImage" :sku="sku" :selectedSkuId="selectedSkuId" />
</template>
