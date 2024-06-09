<script setup>
import { computed } from 'vue'

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
        class="absolute w-full flex justify-center z-10"
        :class="{
               'top-[30px]': entry.hero_size.value !== 'sm',
               'top-[9px] xs:top-[4px] sm:top-[1px]': entry.hero_size.value === 'sm',
        }"
    >
        <h1
            class="block max-w-[600px] text-white text-center uppercase font-bold md:tracking-wide leading-tight"
            :class="{
               'text-headline-base xs:text-headline-lg sm:text-headline-xl md:text-headline-xl'
                    : entry.hero_size.value === 'sm' || entry.title_size.value !== 'lg',
               'text-headline-xl sm:text-headline-2xl md:text-headline-3xl'
                    : entry.hero_size.value !== 'sm' && entry.title_size.value === 'lg',
            }"
        >
            {{ title }}
        </h1>
    </div>
</template>
