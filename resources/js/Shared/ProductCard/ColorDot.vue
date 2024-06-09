<script setup>
import { useColors } from '../../Composables/useColors.js'
import { computed } from 'vue'
import { useShopStore } from '../../Stores/ShopStore.js'
import ActualColorDot from '../ActualColorDot.vue'

const { lightOrDark } = useColors()

const props = defineProps({
    sku: { type: Object, default: {} },
    product: { type: Object, default: {} },
})

const shopStore = useShopStore()

const selectedSkuId = computed(() => shopStore.selectedSkuId[props.product.id])
const isSelected = computed(() => selectedSkuId.value === props.sku.id)
const actualColor = computed(() => props.sku.colors.length ? props.sku.colors[0].rgb : '#aaaaaa')
const title = computed(() => props.sku.colors.length ? props.sku.colors[0].title : '')
const sorter = computed(() => props.sku.colors.length ? props.sku.colors[0].sorter : 0)
const innerBorderColor = computed(() => lightOrDark(actualColor.value) === 'extralight' ? '#cccccc' : actualColor.value)

let isVisible = computed(() => {
    if (
        shopStore.selectedFilters.colorGroup
        && props.sku.colorGroups.indexOf(shopStore.selectedFilters.colorGroup.value) === -1
    ) {
        return false
    }

    if (shopStore.onlyNewIsActive && !props.sku.is_new) {
        return false
    }

    return true
})
</script>

<template>
    <button
        v-if="isVisible"
        class="w-full h-full p-[18%]"

        @click="shopStore.selectSkuId(product.id, sku.id)"
    >
        <ActualColorDot
            :isSelected="isSelected"
            :actualColor="actualColor"
            :title="title"
            :sorter="sorter"
            :innerBorderColor="innerBorderColor"
        />
    </button>
</template>
