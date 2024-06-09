<script setup>
import {useCartStore} from '../../Stores/CartStore'
import BaseArticle from './BaseArticle.vue'

const props = defineProps({
    sku: Object,
})

const cartStore = useCartStore()
const minQuantityOptions = 3


</script>

<template>
    <BaseArticle
        :sku="sku"
        :cartStore="cartStore"
        :minQuantityOptions="minQuantityOptions"
    />
</template>
