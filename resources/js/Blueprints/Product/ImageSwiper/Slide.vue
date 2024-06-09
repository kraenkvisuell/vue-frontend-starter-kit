<script setup>
import Image from '../Image.vue'
import { useProductStore } from '../../../Stores/ProductStore.js'
import SlideZoom from './SlideZoom.vue'

const props = defineProps({
    images: Array,
    product: Object,
    sku: { type: Object, default: null },
    isLast: { type: Boolean, default: false },
    title: { type: String, default: '' },
    alt: { type: String, default: '' },
})

const productStore = useProductStore()

let bgColor = props.sku ? props.sku.colors[0].rgb : ''
</script>

<template>
    <div class="swiper-slide" :class="{'md:pb-bottom-of-slides': isLast}">
        <div class="w-full h-full md:h-auto aspect-w-1 aspect-h-1 md:aspect-w-5 md:aspect-h-6">
            <div
                v-for="(image, imageIndex) in images"
                v-show="productStore.selectedPerspective === image.perspective || imageIndex === 0"
                class="w-full h-full bg-white"
            >
                <Image
                    :image="image"
                    :sku="sku"
                    :alt="alt"
                    :selectedSkuId="productStore.selectedSkuId"
                />

                <div class="
                    md:hidden h-[80px] w-full absolute bottom-0 left-0 bg-gradient-to-t from-darkest opacity-10
                " />

                <SlideZoom v-if="image && !image.is_video" :image="image" />
            </div>
        </div>
    </div>
</template>
