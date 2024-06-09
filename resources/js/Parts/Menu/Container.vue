<script setup>
import DoubleArrow from '../../Svg/DoubleArrow.vue'
import Close from '../../Shared/Close.vue'

const props = defineProps({
    isOpen: { type: Boolean, default: false },
    toggle: Function,
})
</script>

<template>
    <div
        class="transition-opacity duration-500"
        :class="{
            'opacity-100': isOpen,
            'opacity-0': !isOpen,
        }"
    >
        <div
            class="
                absolute max-h-screen bg-gray-100 transition-all duration-500 overflow-scroll
                pb-[50px] pt-[50px] sm:pt-[56px] sm:pb-0 w-[calc(100%-20px)] md:w-full
                h-screen md:h-auto
            "
            :class="{
                'ease-out top-0 right-0': isOpen,
                'ease-in top-0 md:-top-[100vh] -right-[100%] md:right-0': !isOpen,
            }"
        >
            <div class="md:hidden absolute top-[61px] left-[12px] z-30">
                <button
                    class="h-icon w-icon block md:hidden fill-gray-800 hover:fill-black"
                    @click="toggle"
                >
                    <DoubleArrow />
                </button>
            </div>

            <div class="hidden md:block absolute top-[80px] right-[17px] z-20">
                <button @click="toggle">
                    <Close />
                </button>
            </div>

            <div>
                <slot />
            </div>
        </div>
    </div>
</template>
