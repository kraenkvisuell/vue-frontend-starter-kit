<script setup>
import {useProductStore} from '../../Stores/ProductStore.js'

const productStore = useProductStore()
</script>

<template>
    <div
        class="editor text-gray-800 pt-[20px] lg:pt-[30px] 2xl:pt-[35px] pb-[17px] sm:pb-[20px]"
        v-html="productStore.product.description"
    />
</template>
