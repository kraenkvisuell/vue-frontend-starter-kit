<script setup>
import { useHeaderBarStore } from '../../Stores/HeaderBarStore.js'

const headerBarStore = useHeaderBarStore()
</script>

<template>
    <div class="pt-[30px] sm:pt-0">
        <div
            class="z-10 sm:sticky sm:pb-[20px]"
            :class="{
            'sm:top-[72px]': !headerBarStore.headerBarIsVisible,
            'sm:top-[95px]': headerBarStore.headerBarIsVisible,
        }"
        >
            <div class="w-full sm:w-[180px] md:w-[230px] lg:w-[260px] xl:w-[300px] sm:h-shopnavi">
                <slot />
            </div>
        </div>
    </div>
</template>
