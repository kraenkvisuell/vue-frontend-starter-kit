<script setup>
import Close from '../../Svg/Close.vue'
import ColorDot from '../../Shared/ProductCard/ColorDot.vue'
import Image from '../../Shared/ProductCard/Image.vue'
import Price from '../../Shared/ProductCard/Price.vue'
import ProductCard from '../../Shared/ProductCard.vue'
import ProductCardImage from '../../Shared/ProductCardImage.vue'
import ProductCardMain from '../../Shared/ProductCardMain.vue'
import _ from 'lodash'
import { Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { useShopStore } from '../../Stores/ShopStore'

const shopStore = useShopStore()

const props = defineProps({
    product: Object,
})

const maxDotsPerLine = 6

const showAllColors = ref(false)

const rest = computed(() => {
    let skus = props.product.skus

    if (shopStore.selectedFilters.colorGroup) {
        skus = _.filter(skus, function(sku) {
            return sku.colorGroups.indexOf(shopStore.selectedFilters.colorGroup.value) > -1
        })
    }

    if (shopStore.onlyNewIsActive) {
        skus = _.filter(skus, (sku) => sku.is_new)
    }

    return skus.length - maxDotsPerLine + 1
})

const url = computed(() => {
    if (props.product.id && shopStore.selectedSkuId[props.product.id]) {
        let sku = _.find(props.product.skus, { id: shopStore.selectedSkuId[props.product.id] })
        if (sku.colors.length) {
            return props.product.url + '#' + sku.colors[0].slug
        }
    }
    return props.product.url
})

const isVisible = computed(() => {
    return (!shopStore.selectedCategory || props.product.categorySlugs.indexOf(shopStore.selectedCategory) !== -1)
        && (!shopStore.selectedTag || props.product.tagSlugs.indexOf(shopStore.selectedTag) !== -1)
        && (
            !shopStore.selectedProductGroup
            || shopStore.selectedCategory
            || props.product.group_slug === shopStore.selectedProductGroup
        )
        && (
            !shopStore.selectedFilters.colorGroup
            || props.product.colorGroupIds.indexOf(shopStore.selectedFilters.colorGroup.value) !== -1
        )
        && (
            !shopStore.selectedFilters.size
            || props.product.size_string === shopStore.selectedFilters.size.value
        )
        && (
            !shopStore.onlyNewIsActive
            || _.find(props.product.skus, (sku) => sku.is_new)
        )
})
</script>

<template>
    <ProductCard v-show="isVisible">
        <div>
            <Link :href="url">
                <ProductCardImage>
                    <Image
                        v-for="sku in product.skus"
                        :product="product"
                        :sku="sku"
                    />
                </ProductCardImage>

                <ProductCardMain>
                    <template v-slot:tagsString>{{ product.tagsString }}</template>

                    <template v-slot:groupTitle>{{ product.group_title }}</template>

                    <template v-slot:title>{{ product.reduced_title }}</template>

                    <template v-slot:button>
                        <Price :product="product" />
                    </template>
                </ProductCardMain>
            </Link>
        </div>

        <div class=" grid grid-cols-6 px-[3%] pb-[3%]">
            <template v-for="(sku, skuIndex) in product.skus">
                <ColorDot
                    v-show="shopStore.selectedFilters.colorGroup || showAllColors || skuIndex < maxDotsPerLine - 1 || rest <= 1"
                    :sku="sku"
                    :product="product"
                />

                <button
                    v-show="(skuIndex === maxDotsPerLine - 2 && rest > 1) && !shopStore.selectedFilters.colorGroup"
                    @click="showAllColors = !showAllColors"
                    class=" w-full h-full flex items-center justify-center text-copy-xs @card-xl:text-copy-sm"
                >

                    <span v-show="!showAllColors" class="block">
                        + {{ rest }}
                    </span>

                    <span v-show="showAllColors" class="block h-[10px] w-[10px]">
                        <Close />
                    </span>
                </button>
            </template>
        </div>
    </ProductCard>
</template>
