<script setup>
import BreadcrumbLink from './BreadcrumbLink.vue'
import _ from 'lodash'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useProductStore } from '../Stores/ProductStore.js'
import { useShopStore } from '../Stores/ShopStore'

const productStore = useProductStore()
const shopStore = useShopStore()

shopStore.init()

const categoryTitle = computed(() => {
    if (!shopStore.selectedCategory) {
        return ''
    }

    let category = _.find($shared.categories, (category) => category.slug === shopStore.selectedCategory)

    if (category) {
        return category.title
    }
    return ''
})

const productGroupTitle = computed(() => {
    if (!shopStore.selectedProductGroup) {
        return ''
    }

    let productGroup = _.find($shared.productGroups, (productGroup) => productGroup.slug === shopStore.selectedProductGroup)

    if (productGroup) {
        return productGroup.title
    }
    return ''
})

const tagTitle = computed(() => {
    if (!shopStore.selectedTag || !shopStore.selectedCategory) {
        return ''
    }

    let category = _.find($shared.categories, (category) => category.slug === shopStore.selectedCategory)


    if (category) {
        let tag = _.find(category.tags, (tag) => tag.slug === shopStore.selectedTag)

        if (tag) {
            return tag.title
        }
    }
    return ''
})

</script>

<template>
    <div class="text-copy-sm flex flex-wrap items-center leading-none gap-x-[3px] text-gray-600">
        <Link :href="$route('shop', [$shared.locale])">
            <BreadcrumbLink :isFirst="true">
                <span class="underline">{{ $trans.shop.shop }}</span>
            </BreadcrumbLink>
        </Link>

        <Link
            v-if="shopStore.selectedProductGroup && !shopStore.selectedCategory"
            :href="$route('shop.product-group', [$shared.locale, shopStore.selectedProductGroup])"
        >
            <BreadcrumbLink>
                <span class="underline">{{ productGroupTitle }}</span>
            </BreadcrumbLink>
        </Link>

        <Link
            v-if="shopStore.selectedCategory"
            :href="$route('shop.category', [$shared.locale, shopStore.selectedCategory])"
        >
            <BreadcrumbLink>
                <span class="underline">{{ categoryTitle }}</span>
            </BreadcrumbLink>
        </Link>

        <Link
            v-if="shopStore.selectedTag"
            :href="$route('shop.tag', [$shared.locale, shopStore.selectedCategory, shopStore.selectedTag])"
        >
            <BreadcrumbLink>
                <span class="underline">{{ tagTitle }}</span>
            </BreadcrumbLink>
        </Link>

        <span v-if="productStore.product">
            <BreadcrumbLink>
                {{ productStore.product.group_title }} {{ productStore.product.reduced_title }}
            </BreadcrumbLink>
        </span>
    </div>
</template>
