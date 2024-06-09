<script setup>
import Breadcrumb from '../Shared/Breadcrumb.vue'
import Colors from './Product/Colors.vue'
import Description from './Product/Description.vue'
import DetailImages from './Product/DetailImages.vue'
import Details from './Product/Details.vue'
import GalleryZoom from './Product/GalleryZoom.vue'
import HeadMeta from '../Parts/HeadMeta.vue'
import ImageSwiper from './Product/ImageSwiper.vue'
import ImageZoom from './Product/ImageZoom.vue'
import MessageWhenAvailable from '../Modals/MessageWhenAvailable.vue'
import OtherSkus from '../Shared/OtherSkus.vue'
import Price from './Product/Price.vue'
import SectionContainer from './Shared/SectionContainer.vue'
import SeoText from './Product/SeoText.vue'
import Title from './Product/Title.vue'
import { onMounted } from 'vue'
import { useHeaderBarStore } from '../Stores/HeaderBarStore.js'
import { usePage } from '@inertiajs/vue3'
import { useProductStore } from '../Stores/ProductStore.js'
import { useShopStore } from '../Stores/ShopStore.js'

const productStore = useProductStore()
const shopStore = useShopStore()
const headerBarStore = useHeaderBarStore()

onMounted(() => {
    productStore.updateProduct(usePage().props.product)
    productStore.deactivateSlideChangeListener()
    productStore.checkHash()
})
</script>

<template>
    <HeadMeta
        :seoTitle="productStore.seoTitle"
        :ogTitle="productStore.ogTitle"
        :seoDescription="productStore.seoDescription"
        :ogDescription="productStore.ogDescription"
        :ogImage="productStore.ogImage"
        :twitterCardImage="productStore.twitterCardImage"
    />

    <div
        class="pb-[200px] flex flex-col"
        :class="{
            'pt-[50px] sm:pt-[56px]': !headerBarStore.headerBarIsVisible,
            'pt-[73px] sm:pt-[79px]': headerBarStore.headerBarIsVisible,
        }"
    >
        <div class="flex md:hidden px-[24px] h-[50px] items-center leading-none">
            <Breadcrumb />
        </div>

        <div>
            <div class="md:absolute">
                <div
                    class="
                        md:sticky md:top-0 md:left-0
                        w-full md:w-[300px] lg:w-[400px] xl:w-[450px] 2xl:w-[540px]
                    "
                >
                    <div class="md:h-screen">
                        <ImageSwiper />
                        <ImageZoom />
                    </div>
                </div>
            </div>

            <div class="
                w-full md:min-h-screen
                md:w-[calc(100%-300px)] lg:w-[calc(100%-400px)] xl:w-[calc(100%-450px)] 2xl:w-[calc(100%-540px)]
                top-0 left-0 md:left-[300px] lg:left-[400px] xl:left-[450px] 2xl:left-[540px]
            ">
                <div class="w-full flex justify-center sm:px-[20px] md:px-[35px] xl:px-[40px]">
                    <div class="w-full xl:max-w-[800px]">
                        <div class="hidden md:flex items-center leading-none md:py-[18px]">
                            <Breadcrumb />
                        </div>

                        <div class="flex flex-col gap-[5px] md:gap-[30px] xl:gap-[40px]">
                            <div class="sm:px-[35px] xl:px-[40px] sm:py-[30px] xl:py-[35px] sm:bg-white sm:rounded">
                                <div class="flex flex-col sm:flex-col-reverse @container">
                                    <Colors />

                                    <div class="sm:hidden">
                                        <DetailImages />
                                    </div>

                                    <Title />
                                </div>

                                <Price />
                            </div>

                            <div class="hidden sm:block">
                                <DetailImages />
                            </div>
                        </div>

                        <div class="px-[15px] sm:px-0">
                            <Description />

                            <Details />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <SectionContainer>
            <div class="mt-[70px] grid gap-[40px]">
                <OtherSkus
                    :isLoading="productStore.loadingSimilarSkus"
                    :headline="$trans.shop.this_might_interest_you"
                    :loadingText="$trans.shop.loading_similar_products"
                    :skus="productStore.similarSkus"
                />

                <OtherSkus
                    :isLoading="productStore.loadingMatchingSkus"
                    :headline="$trans.shop.this_matches"
                    :loadingText="$trans.shop.loading_matching_products"
                    :skus="productStore.matchingSkus"
                />
            </div>

            <div class="flex justify-center">
                <div class="mt-[40px] max-w-screen-lg">
                    <SeoText />
                </div>
            </div>
        </SectionContainer>

        <GalleryZoom />

        <MessageWhenAvailable :slug="productStore.selectedSku.slug" />
    </div>
</template>
