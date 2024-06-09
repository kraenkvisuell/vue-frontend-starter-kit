<script setup>
import { useMedia } from '../../Composables/useMedia.js'
import { computed, ref } from 'vue'
import { useShopStore } from '../../Stores/ShopStore.js'

const { imageLink } = useMedia()

const props = defineProps({
    sku: { type: Object, default: {} },
    product: { type: Object, default: {} },
})

const shopStore = useShopStore()

const parentImage = ref(null)

const selectedSkuId = computed(() => shopStore.selectedSkuId[props.product.id])

const isSelected = computed(() => selectedSkuId.value === props.sku.id)
</script>

<template>
    <div
        class="w-full h-full absolute top-0 left-0"
        :class="{
            'opacity-100': isSelected,
            'opacity-0': !isSelected,
        }"
    >
        <img
            :src="isSelected ? imageLink(sku.image, { crop: true, fit: [800, 800] }) : '/img/loading01.gif'"
            :alt="product.title+' '+sku.title"
            class="w-[84%] h-[84%] object-contain m-auto"
            loading="lazy"
            ref="parentImage"
        />
    </div>
</template>
