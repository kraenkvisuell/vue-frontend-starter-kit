<script setup>
import { router } from '@inertiajs/vue3'
import { useShop } from '../Composables/useShop.js'
import { useShopStore } from '../Stores/ShopStore'

const shopStore = useShopStore()

const { scrollToProducts } = useShop()

const props = defineProps({
    href: {
        type: String,
        default: '',
    },
})

const handleClick = (e) => {
    e.preventDefault()
    const url = props.href

    router.get(url, {}, {
        only: ['empty'],
        preserveState: true,
        preserveScroll: true,
    })

    const path = url.substring(url.indexOf('//') + 2)
    const arr = path.split('/')
    let slug = arr[3]

    shopStore.selectProductGroup(slug)

    scrollToProducts()
}
</script>

<template>
    <a :href="href" @click="handleClick">
        <slot />
    </a>
</template>
