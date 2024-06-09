<script setup>

import {useProductStore} from '../../Stores/ProductStore.js'
import SkuCard from '../../Shared/SkuCard.vue'
import TextWrapper from '../../Parts/Menu/TextWrapper.vue'
import SmallHeadline from '../../Shared/SmallHeadline.vue'

const productStore = useProductStore()

</script>

<template>
    <div
        v-if="!productStore.loadingSimilarSkus && productStore.similarSkus.length"
        class="w-full max-w-[1250px] m-auto"
    >
        <div
            v-if="productStore.loadingSimilarSkus"
            v-text="$trans.shop.loading_similar_products+'...'"
        />

        <div v-else
             class="grid gap-[12px]"
        >
            <TextWrapper>
                <SmallHeadline>
                    {{ $trans.shop.this_might_interest_you }}:
                </SmallHeadline>
            </TextWrapper>

            <div class="grid grid-cols-2 xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5  xl:grid-cols-6 gap-[4px]">
                <div
                    v-for="sku in productStore.similarSkus"
                    class=""
                >
                    <SkuCard :sku="sku"/>
                </div>
            </div>
        </div>
    </div>
</template>
