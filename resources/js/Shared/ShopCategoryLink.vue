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
    //history.pushState(null, null, url)

    router.get(url, {}, {
        only: ['empty'],

    })

    const path = url.substring(url.indexOf('//') + 2)
    const arr = path.split('/')

    if (arr.length === 4 && arr[3] === 'new') {
        shopStore.activateOnlyNew()
    } else {
        let category = ''
        let tag = ''

        if (arr.length > 3) {
            category = arr[3]
            if (category.indexOf('#') > -1) {
                category = category.substring(0, category.indexOf('#'))
            }
        }

        if (arr.length > 4) {
            tag = arr[4]
            if (tag.indexOf('#') > -1) {
                tag = tag.substring(0, tag.indexOf('#'))
            }
        }

        shopStore.changeCategory(category, tag)
    }


    scrollToProducts()
}
</script>

<template>
    <a :href="href" @click="handleClick">
        <slot />
    </a>
</template>
