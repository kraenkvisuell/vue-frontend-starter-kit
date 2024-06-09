<script setup>
import { useHeaderBarStore } from '../Stores/HeaderBarStore.js'
import { ref } from 'vue'
import Icon from './Menu/Filters/Icon.vue'

const headerBarStore = useHeaderBarStore()

const show = ref(false)

addEventListener('scroll', function() {
    if (scrollY > 300) {
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
        v-show="show"
        @click="scrollToTop"
        class="
            sm:hidden
            fixed left-[calc(50%-16px)]
            group text-gray-800 text-copy-sm tracking-normal gap-[7px]
            w-[32px] flex flex-col items-center
        "
        :class="{
            'top-[70px]': !headerBarStore.headerBarIsVisible,
            'top-[93px]': headerBarStore.headerBarIsVisible,
        }"
    >
        <div class="w-[32px] h-[32px] flex items-center justify-center rounded-full bg-gray-800">
            <div class="w-icon h-icon text-white flex justify-center">
                <Icon />
            </div>
        </div>

        <div class="
            opacity-0 group-hover:opacity-100 rounded-full bg-gray-800 text-white leading-tightest
            px-[10px] py-[3px] text-copy-xs whitespace-nowrap
        ">
            {{ $trans.shop.categories_and_filters }}
        </div>
    </button>
</template>
