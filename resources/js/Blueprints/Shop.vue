<script setup>
import HeadMeta from '../Parts/HeadMeta.vue'
import Hero from '../Parts/Hero.vue'
import PageContainer from './Shared/PageContainer.vue'
import ProductCards from '../Shared/ProductCards.vue'
import ShopNavi from '../Parts/Menu/ShopNavi.vue'
import ShopNaviContainer from './Shared/ShopNaviContainer.vue'
import ShopIntro from './Shop/ShopIntro.vue'
import ShopProductCard from './Shop/ShopProductCard.vue'
import ToggleMobileShopNavi from '../Parts/ToggleMobileShopNavi.vue'
import _ from 'lodash'
import { computed, watch } from 'vue'
import { useShopStore } from '../Stores/ShopStore'

const shopStore = useShopStore()

const props = defineProps({
    products: {
        type: Array,
        default: [],
    },
})

shopStore.init()
shopStore.initProducts(props.products)

const title = computed(() => {
    if (shopStore.currentProductGroup && shopStore.currentProductGroup.title && !shopStore.selectedCategory) {
        return shopStore.currentProductGroup.title
    }

    if (shopStore.currentTag && shopStore.currentTag.title && shopStore.selectedTag) {
        return shopStore.currentTag.title
    }

    if (shopStore.currentCategory && shopStore.currentCategory.title && shopStore.selectedCategory) {
        return shopStore.currentCategory.title
    }

    return $shared.globals.shop.shop_title ? $shared.globals.shop.shop_title : 'Shop'
})

const entryForHero = computed(() => {
    return {
        title: title.value,
        show_title: true,
        hero_size: $shared.globals.shop.hero_size,
        hero_type: $shared.globals.shop.hero_type,
        hero_slideshow: $shared.globals.shop.hero_slideshow,
    }
})

const seoTitle = computed(() => {
    if (
        shopStore.currentProductGroup
        && !shopStore.selectedCategory
        && shopStore.currentProductGroup.seo_title
        && shopStore.currentProductGroup.seo_title.text
    ) {
        return shopStore.currentProductGroup.seo_title.text
    }

    if (shopStore.currentTag && shopStore.currentTag.seo_title && shopStore.currentTag.seo_title.text) {
        return shopStore.currentTag.seo_title.text
    }

    if (shopStore.currentCategory && shopStore.selectedCategory && shopStore.currentCategory.seo_title && shopStore.currentCategory.seo_title.text) {
        return shopStore.currentCategory.seo_title.text
    }

    return title.value
})

const ogTitle = computed(() => {
    if (shopStore.currentProductGroup && !shopStore.selectedCategory) {
        if (shopStore.currentProductGroup.og_title && shopStore.currentProductGroup.og_title.text) {
            return shopStore.currentProductGroup.og_title.text
        }

        if (shopStore.currentProductGroup.seo_title && shopStore.currentProductGroup.seo_title.text) {
            return shopStore.currentProductGroup.seo_title.text
        }
    }

    if (shopStore.currentTag) {
        if (shopStore.currentTag.og_title && shopStore.currentTag.og_title.text) {
            return shopStore.currentTag.og_title.text
        }

        if (shopStore.currentTag.seo_title && shopStore.currentTag.seo_title.text) {
            return shopStore.currentTag.seo_title.text
        }
    }

    if (shopStore.currentCategory && shopStore.selectedCategory) {
        if (shopStore.currentCategory.og_title && shopStore.currentCategory.og_title.text) {
            return shopStore.currentCategory.og_title.text
        }

        if (shopStore.currentCategory.seo_title && shopStore.currentCategory.seo_title.text) {
            return shopStore.currentCategory.seo_title.text
        }
    }

    return title.value
})

const seoDescription = computed(() => {
    if (
        shopStore.currentProductGroup
        && !shopStore.selectedCategory
        && shopStore.currentProductGroup.seo_description
        && shopStore.currentProductGroup.seo_description.text
    ) {
        return shopStore.currentProductGroup.seo_description.text
    }

    if (shopStore.currentTag && shopStore.currentTag.seo_description && shopStore.currentTag.seo_description.text) {
        return shopStore.currentTag.seo_description.text
    }

    if (shopStore.currentCategory && shopStore.selectedCategory && shopStore.currentCategory.seo_description && shopStore.currentCategory.seo_description.text) {
        return shopStore.currentCategory.seo_description.text
    }

    if ($shared.globals.shop.seo_description && $shared.globals.shop.seo_description.text) {
        return $shared.globals.shop.seo_description.text
    }

    return ''
})

const ogDescription = computed(() => {
    if (shopStore.currentProductGroup && !shopStore.selectedCategory) {
        if (shopStore.currentProductGroup.og_description && shopStore.currentProductGroup.og_description.text) {
            return shopStore.currentProductGroup.og_description.text
        }

        if (shopStore.currentProductGroup.seo_description && shopStore.currentProductGroup.seo_description.text) {
            return shopStore.currentProductGroup.seo_description.text
        }
    }

    if (shopStore.currentTag) {
        if (shopStore.currentTag.og_description && shopStore.currentTag.og_description.text) {
            return shopStore.currentTag.og_description.text
        }

        if (shopStore.currentTag.seo_description && shopStore.currentTag.seo_description.text) {
            return shopStore.currentTag.seo_description.text
        }
    }

    if (shopStore.currentCategory && shopStore.selectedCategory) {
        if (shopStore.currentCategory.og_description && shopStore.currentCategory.og_description.text) {
            return shopStore.currentCategory.og_description.text
        }

        if (shopStore.currentCategory.seo_description && shopStore.currentCategory.seo_description.text) {
            return shopStore.currentCategory.seo_description.text
        }
    }

    if ($shared.globals.shop.og_description && $shared.globals.shop.og_description.text) {
        return $shared.globals.shop.og_description.text
    }

    return null
})

const ogImage = computed(() => {
    if (
        shopStore.currentProductGroup
        && !shopStore.selectedCategory
        && shopStore.currentProductGroup.og_image
        && shopStore.currentProductGroup.og_image.is_image
    ) {
        return shopStore.currentProductGroup.og_image
    }

    if (shopStore.currentTag && shopStore.currentTag.og_image && shopStore.currentTag.og_image.is_image) {
        return shopStore.currentTag.og_image
    }

    if (shopStore.currentCategory && shopStore.selectedCategory && shopStore.currentCategory.og_image && shopStore.currentCategory.og_image.is_image) {
        return shopStore.currentCategory.og_image
    }

    if ($shared.globals.shop.og_image && $shared.globals.shop.og_image.is_image) {
        return $shared.globals.shop.og_image
    }

    return null
})

const twitterCardImage = computed(() => {
    if (shopStore.currentProductGroup && !shopStore.selectedCategory) {
        if (shopStore.currentProductGroup.twitter_card_image && shopStore.currentProductGroup.twitter_card_image.is_image) {
            return shopStore.currentProductGroup.twitter_card_image
        }

        if (shopStore.currentProductGroup.og_image && shopStore.currentProductGroup.og_image.is_image) {
            return shopStore.currentProductGroup.og_image
        }
    }

    if (shopStore.currentTag) {
        if (shopStore.currentTag.twitter_card_image && shopStore.currentTag.twitter_card_image.is_image) {
            console.log(shopStore.currentTag.twitter_card_image)
            return shopStore.currentTag.twitter_card_image
        }

        if (shopStore.currentTag.og_image && shopStore.currentTag.og_image.is_image) {
            return shopStore.currentTag.og_image
        }
    }

    if (shopStore.currentCategory && shopStore.selectedCategory) {
        if (shopStore.currentCategory.twitter_card_image && shopStore.currentCategory.twitter_card_image.is_image) {
            return shopStore.currentCategory.twitter_card_image
        }

        if (shopStore.currentCategory.og_image && shopStore.currentCategory.og_image.is_image) {
            return shopStore.currentCategory.og_image
        }
    }

    if ($shared.globals.shop.twitter_card_image && $shared.globals.shop.twitter_card_image.is_image) {
        return $shared.globals.shop.twitter_card_image
    }

    return ogImage.value
})

const selectPrimarySkus = () => {
    _.each(props.products, (product) => {
        shopStore.selectSkuId(product.id, product.skus[0].id)
    })
}

const selectSkusOfColorGroup = (colorGroupId) => {
    _.each(props.products, (product) => {
        let selectedOne = false
        _.each(product.skus, (sku) => {
            if (!selectedOne && sku.colorGroups.indexOf(colorGroupId) > -1) {
                shopStore.selectSkuId(product.id, sku.id)
                selectedOne = true
            }
        })
    })
}

const selectSkusOfNew = () => {
    _.each(props.products, (product) => {
        let selectedOne = false
        _.each(product.skus, (sku) => {
            if (!selectedOne && sku.is_new) {
                shopStore.selectSkuId(product.id, sku.id)
                selectedOne = true
            }
        })
    })
}

const checkUrl = (url) => {
    const path = url.substring(url.indexOf('//') + 2)
    const arr = path.split('/')

    if (arr.length > 3 && arr[2] === 'kollektion') {
        shopStore.selectProductGroup(arr[3])
    } else if (arr.length === 4 && arr[3] === 'new') {
        shopStore.activateOnlyNew()
    } else {
        let category = arr.length > 3 ? arr[3] : ''
        if (category.indexOf('#') > -1) {
            category = category.substring(0, category.indexOf('#'))
        }

        let tag = arr.length > 4 ? arr[4] : ''
        if (tag.indexOf('#') > -1) {
            tag = tag.substring(0, tag.indexOf('#'))
        }

        shopStore.changeCategory(category, tag)
    }
}

watch(() => shopStore.selectedFilters, () => {
    let newColorGroup = shopStore.selectedFilters.colorGroup ? shopStore.selectedFilters.colorGroup.value : 0
    if (newColorGroup) {
        selectSkusOfColorGroup(newColorGroup)
    } else {
        selectPrimarySkus()
    }
}, { deep: true })

watch(() => shopStore.onlyNewIsActive, () => {
    if (shopStore.onlyNewIsActive) {
        selectSkusOfNew()
    } else {
        selectPrimarySkus()
    }
}, { deep: true })

selectPrimarySkus()

checkUrl(location.href)
</script>

<template>
    <HeadMeta
        :seoTitle="seoTitle"
        :ogTitle="ogTitle"
        :seoDescription="seoDescription"
        :ogDescription="ogDescription"
        :ogImage="ogImage"
        :twitterCardImage="twitterCardImage"
    />

    <Hero :entry="entryForHero" />

    <PageContainer>
        <ShopNaviContainer>
            <ShopNavi />
        </ShopNaviContainer>

        <div class="pb-[250px] w-full @container scroll-mt-[70px]" id="products">
            <ProductCards>
                <ShopProductCard
                    v-for="product in shopStore.products"
                    :product="product"
                />
            </ProductCards>

            <ShopIntro />
        </div>

        <ToggleMobileShopNavi />
    </PageContainer>
</template>
