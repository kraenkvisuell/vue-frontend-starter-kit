<script setup>
import 'swiper/css'
import 'swiper/css/free-mode'
import 'swiper/css/mousewheel'
import BackArrow from '../../Shared/Swiper/BackArrow.vue'
import ForwardArrow from '../../Shared/Swiper/ForwardArrow.vue'
import Slide from './ImageSwiper/Slide.vue'
import Swiper from 'swiper'
import _ from 'lodash'
import { FreeMode, Mousewheel } from 'swiper/modules'
import { onMounted, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { useProductStore } from '../../Stores/ProductStore.js'
import { useDebounce } from '../../Composables/useDebounce.js'

const { debounce } = useDebounce()

const productStore = useProductStore()
const { selectedSkuId } = storeToRefs(productStore)

const swiperIsAtStart = ref(true)
const swiperIsAtEnd = ref(false)

let swiper = null

onMounted(() => {
    swiper = new Swiper('#swiperNode', {
        modules: [FreeMode, Mousewheel],
        speed: 400,
        loop: false,
        spaceBetween: 0,
        mousewheel: {
            releaseOnEdges: true,
            forceToAxis: true,
        },
        freeMode: {
            enabled: false,
        },
        breakpoints: {
            768: {
                direction: 'vertical',
                spaceBetween: 4,
                slidesPerView: 'auto',
                freeMode: {
                    enabled: true,
                },
            },
        },
        on: {
            slideChange: (swiper) => {
                if (productStore.okToListenToSlideChange) {
                    debouncedSlideChange(swiper)
                }
            },

            click: (swiper) => {
                if (swiper.clickedIndex < productStore.product.skus.length) {
                    let sku = productStore.product.skus[swiper.clickedIndex]
                    productStore.selectSkuId(sku.id, sku.colors[0].slug)
                    swiper.slideTo(swiper.clickedIndex)
                }
            },
        },
    })

    if (productStore.selectedSkuId) {
        let index = _.findIndex(productStore.product.skus, (sku) => sku.id === productStore.selectedSkuId)
        swiper.slideTo(index)
    }

    watch(() => productStore.selectedSkuId, () => {
        let index = _.findIndex(productStore.product.skus, (sku) => sku.id === productStore.selectedSkuId)

        window.setTimeout(() => {
            swiper.slideTo(index)

            window.setTimeout(() => productStore.activateSlideChangeListener(), 1000)
        }, 300)
    })
})

const debouncedSlideChange = debounce((swiper) => {
    if (productStore.okToListenToSlideChange) {
        swiperIsAtStart.value = swiper.isBeginning
        swiperIsAtEnd.value = swiper.isEnd
        let sku = productStore.product.skus[swiper.realIndex]

        productStore.selectSkuId(sku.id, sku.colors[0].slug)
    }
}, 200)

const swipePrev = () => {
    swiper.slidePrev()
}

const swipeNext = () => {
    swiper.slideNext()
}

// console.log(productStore.product)
</script>

<template>
    <div class="h-full md:h-screen">
        <div class="h-full product-image-swiper swiper" id="swiperNode">
            <div class="h-full swiper-wrapper">
                <Slide
                    v-for="(sku, skuIndex) in productStore.product.skus"
                    :key="'slide_'+sku.id"
                    :images="sku.images"
                    :sku="sku"
                    :product="productStore.product"
                    :title="sku.colors[0].title"
                    :alt="productStore.product.title+' '+sku.colors[0].title"
                    :isLast="skuIndex === productStore.product.skus.length - 1"
                />
            </div>
        </div>

        <BackArrow :swiperIsAtStart="swiperIsAtStart" :swipePrev="swipePrev" class="md:hidden" />
        <ForwardArrow :swiperIsAtEnd="swiperIsAtEnd" :swipeNext="swipeNext" class="md:hidden" />

        <div
            class="
                hidden md:block absolute bottom-0 left-0 z-10 w-full h-[70px]
                bg-gradient-to-t from-gray-100 to-transparent
            "
        />
    </div>
</template>
