<script setup>
import { useMedia } from '../../Composables/useMedia.js'
import LargeClose from '../../Svg/LargeClose.vue'
import { ref, watch } from 'vue'
import { useScrollLock } from '../../Composables/useScrollLock.js'
import { useZoomGalleryStore } from '../../Stores/ZoomGalleryStore.js'
import Swiper from 'swiper'
import ForwardArrow from '../../Shared/Swiper/ForwardArrow.vue'
import BackArrow from '../../Shared/Swiper/BackArrow.vue'


const { imageLink, videoLink } = useMedia()
const { lockBody, unlockBody } = useScrollLock()
const zoomGalleryStore = useZoomGalleryStore()
const dialog = ref(null)
const swiperIsAtStart = ref(true)
const swiperIsAtEnd = ref(false)

let swiper = null

watch(() => zoomGalleryStore.isVisible, () => {
    if (zoomGalleryStore.isVisible) {

        setTimeout(() => {
            dialog.value.showModal()

            if (!swiper) {
                swiper = new Swiper('#miscGalleryNode', {
                    speed: 400,
                    loop: false,
                    spaceBetween: 0,
                    on: {
                        slideChange: (swiper) => {
                            swiperIsAtStart.value = swiper.isBeginning
                            swiperIsAtEnd.value = swiper.isEnd
                        },
                    },
                })
            }

            setTimeout(() => {
                swiper.slideTo(zoomGalleryStore.currentIndex)
                swiperIsAtStart.value = swiper.isBeginning
                swiperIsAtEnd.value = swiper.isEnd
            }, 100)
        }, 100)

        lockBody()
    } else {
        dialog.value.close()
        unlockBody()
    }
})

const swipePrev = () => {
    swiper.slidePrev()
}

const swipeNext = () => {
    swiper.slideNext()
}

// console.log(productStore.product)
</script>

<template>
    <Teleport to="body">
        <dialog
            ref="dialog"
            id="galleryZoom"
            class="
                p-0 relative bg-white rounded border-0
                shadow-lg w-[calc(100%-60px)] h-[calc(100%-60px)]
            "
        >
            <div class="z-0">
                <div class="h-full w-full swiper" id="miscGalleryNode">
                    <div class="h-full swiper-wrapper">
                        <div
                            v-for="slide in zoomGalleryStore.slides"
                            class="w-full h-full swiper-slide"
                        >
                            <div class="w-full h-full">
                                <div class="w-full h-full bg-white">
                                    <div class="w-full h-dialog-img flex items-center justify-center">
                                        <img
                                            v-if="slide.is_image"
                                            :src="imageLink(slide, {width: 1000})"
                                            class="w-full h-full object-contain"
                                            ref="parentImage"
                                        />

                                        <video
                                            v-if="slide.is_video"
                                            class="w-full h-full object-contain"
                                            playsinline controls
                                        >
                                            <source :src="videoLink(slide)" :type="slide.mime_type" />
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <BackArrow :swiperIsAtStart="swiperIsAtStart" :swipePrev="swipePrev" />
                <ForwardArrow :swiperIsAtEnd="swiperIsAtEnd" :swipeNext="swipeNext" />
            </div>

            <div class="absolute z-10 top-[6px] right-[38px]">
                <button
                    class="fixed w-[32px] h-[32px] flex items-center justify-center bg-white rounded-full"
                    @click="zoomGalleryStore.hide()"
                >
                    <span class="block w-[16px] h-[16px]">
                        <LargeClose />
                    </span>
                </button>
            </div>
        </dialog>

    </Teleport>
</template>

<style scoped>
dialog {
    @apply fixed top-0 left-0;
}

dialog::backdrop {
    @apply bg-black/90;
}
</style>
