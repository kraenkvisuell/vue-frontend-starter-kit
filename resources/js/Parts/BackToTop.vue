<script setup>
import DoubleArrow from '../Svg/DoubleArrow.vue'
import {ref} from 'vue'

// console.log($shared.globals.website.social_media)

const show = ref(false)

addEventListener('scroll', function () {
    if (scrollY > 600) {
        show.value = true
    } else {
        show.value = false
    }
})

const scrollToTop = () => {
    scrollTo(0, 0)
}
</script>

<template>
    <button
        @click="scrollToTop"
        class="
            z-40 sticky left-[calc(100%-42px)] sm:left-[calc(100%-50px)] bottom-[10px]
            w-[40px] h-[40px]  flex justify-center items-center
            transition-opacity
        "
        :class="{
            'opacity-0': !show,
            'opacity-full': show
        }"
    >

        <div
            class="
                w-[24px] h-[24px] sm:w-[30px] sm:h-[30px] bg-gray-100 md:bg-transparent
                rounded-full flex justify-center items-center
            "
        >
            <div class="w-[30px] -rotate-90">
                <DoubleArrow/>
            </div>
        </div>

    </button>
</template>
