<script setup>
import money from '../../money.js'
import { useShopStore } from '../../Stores/ShopStore.js'
import { computed } from 'vue'

const shopStore = useShopStore()

const props = defineProps({
    product: { type: Object, default: {} },
})

const selectedSkuId = computed(() => shopStore.selectedSkuId[props.product.id])
</script>

<template>
    <div>
        <div
            v-for="sku in product.skus"
            class="whitespace-nowrap"
            :class="{
                'hidden': selectedSkuId !== sku.id,
            }"
        >
            {{ money.formatted(sku.price, 'de') }}&nbsp;{{ $shared.currencySign }}
        </div>
    </div>
</template>
