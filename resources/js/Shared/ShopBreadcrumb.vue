<script setup>
import {useShopStore} from '../Stores/ShopStore'
import _ from 'lodash'
import {computed} from 'vue'
import BreadcrumbLink from './BreadcrumbLink.vue'
import ShopCategoryLink from './ShopCategoryLink.vue'

const props = defineProps({
    product: {
        type: Object,
        default: null
    }
})

const shopStore = useShopStore()

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
    <div class="text-copy-sm text-black flex flex-wrap items-center leading-none gap-x-[5px]">
        <div class="hidden sm:block">
            <ShopCategoryLink :url="$route('shop', [$shared.locale])">
                <BreadcrumbLink :isFirst="true">
                    <span class="">{{ $trans.shop.all_categories }}</span>
                </BreadcrumbLink>
            </ShopCategoryLink>
        </div>

        <ShopCategoryLink
            v-if="shopStore.selectedCategory"
            :href="$route('shop.category', [$shared.locale, shopStore.selectedCategory])"
        >
            <BreadcrumbLink>
                <span class="">{{ categoryTitle }}</span>
            </BreadcrumbLink>
        </ShopCategoryLink>

        <ShopCategoryLink
            v-if="shopStore.selectedTag"
            :href="$route('shop.tag', [$shared.locale, shopStore.selectedCategory, shopStore.selectedTag])"
        >
            <BreadcrumbLink>
                <span class="">{{ tagTitle }}</span>
            </BreadcrumbLink>
        </ShopCategoryLink>
    </div>
</template>
