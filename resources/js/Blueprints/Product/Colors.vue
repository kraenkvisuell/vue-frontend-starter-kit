<script setup>
import ColorDot from '../../Blueprints/Product/ColorDot.vue'
import { useProductStore } from '../../Stores/ProductStore.js'

const productStore = useProductStore()

</script>

<template>
    <div class="
        bg-white sm:my-[25px] p-[15px] sm:p-0 sm:ml-[-8px]
        grid grid-cols-6 @md:grid-cols-8 @lg:grid-cols-10 @xl:grid-cols-11 @2xl:grid-cols-12
    ">
        <div v-for="sku in productStore.product.skus">
            <ColorDot :sku="sku" />
        </div>
    </div>
</template>
