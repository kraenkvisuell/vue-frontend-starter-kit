<script setup>
import ActualColorDot from '../../Shared/ActualColorDot.vue'
import { computed } from 'vue'
import { useColors } from '../../Composables/useColors.js'
import { useProductStore } from '../../Stores/ProductStore.js'

const { lightOrDark } = useColors()

const props = defineProps({
    sku: { type: Object, default: null },
    isVideo: { type: Boolean, default: false },
})

const productStore = useProductStore()

const isSelected = computed(() => {
    return !props.isVideo
        ? productStore.selectedSkuId === props.sku.id
        : productStore.videoIsSelected
})

const actualColor = computed(() => {
    return !props.isVideo
        ? (props.sku.colors.length ? props.sku.colors[0].rgb : { value: '#fefefe' })
        : '#E0E0E0'
})

const innerBorderColor = computed(() => {
    return !props.isVideo
        ? (lightOrDark(actualColor.value) === 'extralight' ? '#cccccc' : (actualColor.value))
        : '#E0E0E0'
})

const clickHandler = () => {
    productStore.selectSkuId((props.sku ? props.sku.id : null), (props.sku ? props.sku.colors[0].slug : null), props.isVideo)
}
</script>

<template>
    <button
        class="w-full h-full p-[12%]"
        @click="clickHandler"
    >
        <ActualColorDot
            :isSelected="isSelected"
            :isVideo="isVideo"
            :actualColor="actualColor"
            :innerBorderColor="innerBorderColor"

        />
    </button>
</template>
