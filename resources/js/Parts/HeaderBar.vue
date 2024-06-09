<script setup>
import { onMounted } from 'vue'
import { useHeaderBarStore } from '../Stores/HeaderBarStore.js'
import HeaderBarItem from './HeaderBarItem.vue'

const headerBarStore = useHeaderBarStore()

onMounted(() => {
    headerBarStore.startMobileSlideshow()
})
</script>

<template>
    <div
        v-if="headerBarStore.headerBarIsVisible"
        class="
            z-30 bg-black uppercase font-semibold tracking-wide text-white text-copy-2xs leading-none
            px-[12px] md:px-[20px] py-[3px] lg:py-[6px] h-[23px]
        "
    >

        <div class="lg:hidden">
            <div
                v-for="(item, itemIndex) in headerBarStore.mobileItems"
                class="transition-opacity duration-500"
                :class="{
                    'opacity-0': itemIndex !== headerBarStore.visibleMobileItem,
                    'opacity-full': itemIndex === headerBarStore.visibleMobileItem,
                }"
            >
                <HeaderBarItem :item="item" class="absolute top-[4px] left-0 text-center w-full h-full" />
            </div>
        </div>

        <div class="hidden lg:grid grid-cols-3 pt-[1px]">
            <HeaderBarItem :item="headerBarStore.website.header_bar_left" />

            <HeaderBarItem :item="headerBarStore.website.header_bar_center" class="text-center" />

            <HeaderBarItem :item="headerBarStore.website.header_bar_right" class="text-right" />
        </div>
    </div>
</template>
