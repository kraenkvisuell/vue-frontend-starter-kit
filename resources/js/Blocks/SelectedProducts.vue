<script setup>
import _ from 'lodash'
import { onMounted } from 'vue'
import ShopProductCard from '../Blueprints/Shop/ShopProductCard.vue'
import BlockYMargin from '../Shared/BlockYMargin.vue'
import ProductCards from '../Shared/ProductCards.vue'
import { useShopStore } from '../Stores/ShopStore.js'

const shopStore = useShopStore()

const props = defineProps({
    block: Object,
})

const selectPrimarySkus = () => {
    _.each(props.block.products, (product) => {
        shopStore.selectSkuId(product.id, product.skus[0].id)
    })
}

onMounted(() => {
    shopStore.clear()
    selectPrimarySkus()
})
</script>

<template>
    <BlockYMargin>
        <div class="w-full @container scroll-mt-[70px]">
            <ProductCards>
                <ShopProductCard
                    v-for="product in block.products"
                    :product="product"
                />
            </ProductCards>
        </div>
    </BlockYMargin>
</template>

