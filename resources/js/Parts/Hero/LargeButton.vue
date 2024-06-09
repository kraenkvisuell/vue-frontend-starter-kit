<script setup>
import { useLinks } from '../../Composables/useLinks.js'

const { getLink } = useLinks()

const props = defineProps({
    entry: {
        type: Object,
        default: {},
    },
})
</script>

<template>
    <div
        class="
            pointer-events-none absolute z-10 flex w-full justify-center
            px-[12px] sm:px-[20px] md:px-[40px] lg:px-[60px]
        "
        :class="{
            'bottom-[90px]': entry.hero_size.value === 'lg',
            'bottom-[50px]': entry.hero_size.value === 'md',
        }"
    >
        <a
            class="pointer-events-auto rounded-full leading-tight bg-black/75 px-[50px] py-[14px]"
            :href="getLink(entry, 'hero_')"
        >
            <span
                class="ml-[3px] inline-block text-center text-headline-lg font-bold uppercase tracking-wide text-white"
            >
                {{ entry.hero_link_text.text }}
            </span>
        </a>
    </div>
</template>
