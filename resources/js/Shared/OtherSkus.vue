<script setup>

import SkuCard from './SkuCard.vue'
import TextWrapper from '../Parts/Menu/TextWrapper.vue'
import SmallHeadline from './SmallHeadline.vue'

const props = defineProps({
    headline: String,
    isLoading: Boolean,
    loadingText: String,
    skus: Array,
})

</script>

<template>
    <div
        v-if="!isLoading && skus.length"
        class="w-full max-w-[1250px] m-auto"
    >
        <div
            v-if="isLoading"
            v-text="loadingText+'...'"
        />

        <div v-else
             class="grid gap-[12px]"
        >
            <TextWrapper>
                <SmallHeadline>
                    {{ headline }}:
                </SmallHeadline>
            </TextWrapper>

            <div class="grid grid-cols-2 xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5  xl:grid-cols-6 gap-[4px]">
                <div v-for="sku in skus">
                    <SkuCard :sku="sku"/>
                </div>
            </div>
        </div>
    </div>
</template>
