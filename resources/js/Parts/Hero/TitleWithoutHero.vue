<script setup>
import { computed } from 'vue'
import { useHeaderBarStore } from '../../Stores/HeaderBarStore.js'

const headerBarStore = useHeaderBarStore()

const props = defineProps({
    entry: {
        type: Object,
        default: {},
    },
})

const title = computed(() => {
    if (props.entry.localized_title && props.entry.localized_title.text) {
        return props.entry.localized_title.text
    }

    return props.entry.title
})
</script>

<template>
    <div
        class="w-full pb-[35px] sm:pb-[5px] flex flex-col items-center z-10 top-[30px] px-[10px]"
        :class="{
            'pt-[50px] sm:pt-[56px]': !headerBarStore.headerBarIsVisible,
            'pt-[73px] sm:pt-[79px]': headerBarStore.headerBarIsVisible,
        }"
    >
        <h1
            class="
                block max-w-[600px] md:max-w-[768px] uppercase font-bold md:tracking-wide text-center
                text-headline-base leading-tight
            "
            :class="{
                'xs:text-headline-lg sm:text-headline-xl md:text-headline-2xl': entry.title_size.value === 'lg',
                'sm:text-headline-lg md:text-headline-xl': entry.title_size.value === 'md',
                'sm:text-headline-lg': entry.title_size.value === 'sm',
            }"
        >
            {{ title }}
        </h1>
    </div>
</template>
