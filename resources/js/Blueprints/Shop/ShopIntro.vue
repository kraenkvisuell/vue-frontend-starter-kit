<script setup>
import { computed } from 'vue'
import { useShopStore } from '../../Stores/ShopStore.js'

const shopStore = useShopStore()

const intro = computed(() => {
    if (
        shopStore.currentProductGroup
        && !shopStore.selectedCategory
        && shopStore.currentProductGroup.description
    ) {
        return shopStore.currentProductGroup.description
    }

    if (shopStore.currentTag && shopStore.currentTag.description && shopStore.currentTag.description.text) {
        return shopStore.currentTag.description.text
    }

    if (
        shopStore.currentCategory
        && shopStore.selectedCategory
        && shopStore.currentCategory.description
        && shopStore.currentCategory.description.text
    ) {
        return shopStore.currentCategory.description.text
    }

    return $shared.globals.shop.intro ? $shared.globals.shop.intro.text : ''
})
</script>

<template>
    <div v-show="intro" class="w-full flex justify-center">
        <div class="editor text-center mt-[30px] max-w-screen-md">
            <div v-html="intro" />
        </div>
    </div>
</template>
