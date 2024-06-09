<script setup>
const props = defineProps({
    title: String,
    position: {
        type: String,
        default: 'top',
    },
    size: {
        type: String,
        default: 'md',
    },
})
</script>

<template>
    <div
        class="absolute inset-0 flex flex-col"
        :class="{
                'justify-start': position === 'top',
                'justify-center': position === 'centered',
                'justify-end': position === 'bottom',
            }"
    >
        <div
            class="
               z-10 w-full left-0 text-center leading-tight uppercase
               py-[12px] @sm:py-[20px] @lg:py-[30px]
               text-white font-bold tracking-wide
           "
            :class="{
                'text-headline-sm @md:text-headline-base': size === 'sm',
                'text-headline-base @md:text-headline-lg': size === 'md',
                'text-headline-lg @md:text-headline-xl': size === 'lg',
            }"
            v-html="title"
        />

        <div
            v-if="position !== 'centered'"
            class=" absolute left-0 z-0 w-full h-[200px] @sm:h-[300px]"
            :class="{
                'top-0 bg-gradient-to-b from-[rgba(0,0,0,0.7)] to-[rgba(0,0,0,0)]': position === 'top',
                'bottom-0 bg-gradient-to-t from-[rgba(0,0,0,0.7)] to-[rgba(0,0,0,0)]': position === 'bottom',
            }"
        />
    </div>
</template>
