<script setup>
const props = defineProps({
    hasMarginLeft: {type: Boolean, default: false},
    width: {type: String, default: 'base'},
})
</script>

<template>
    <div
        class="w-full flex justify-center"
        :class="{
            'pl-[15px] sm:pl-[20px] md:pl-[35px] lg:pl-[365px] pr-[15px] sm:pr-[20px] md:pr-[35px] xl:pr-[40px]' : hasMarginLeft,
            'px-[15px] sm:px-[20px] md:px-[35px] xl:px-[40px]' : !hasMarginLeft,
        }"
    >
        <div
            class="w-full"
            :class="{
                'max-w-screen-md': width === 'base',
                'max-w-screen-lg': width === 'lg',
                'max-w-screen-xl': width === 'xl',
            }"
        >
            <slot/>
        </div>
    </div>
</template>
