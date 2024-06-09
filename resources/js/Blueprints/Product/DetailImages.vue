<script setup>
import { useProductStore } from '../../Stores/ProductStore.js'
import SkuDetailImage from './SkuDetailImage.vue'

const productStore = useProductStore()
</script>

<template>
    <div>
        <div class="bg-white p-[8px] sm:p-[12px] @container flex gap-[8px]">
            <SkuDetailImage
                v-for="(image, imageIndex) in productStore.currentDetailImages"
                :image="image"
                :imageIndex="imageIndex"
            />
        </div>
    </div>
</template>
