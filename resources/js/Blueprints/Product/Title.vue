<script setup>
import { useProductStore } from '../../Stores/ProductStore.js'

const productStore = useProductStore()
</script>


<template>
    <h1 class="pt-[20px] sm:pt-0 px-[15px] sm:px-0 text-copy-sm text-gray-800 tracking-normal">
        <span class="block">
            {{ productStore.product.topline ? productStore.product.topline : productStore.product.tags_string }}
        </span>

        <span class="text-black text-headline-base md:text-headline-lg flex gap-[15px]">
            <span class="block font-bold tracking-normal">
                {{ productStore.product.group_title }} {{ productStore.product.reduced_title }}
            </span>

            <span v-for="sku in productStore.product.skus" v-show="sku.id === productStore.selectedSkuId"
                  class="block uppercase">
                {{ sku.colors[0].title }}
            </span>
        </span>
    </h1>
</template>
