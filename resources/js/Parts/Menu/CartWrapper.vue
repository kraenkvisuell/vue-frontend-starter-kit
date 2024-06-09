<script setup>
const props = defineProps({
    isBusy: Boolean,
})
</script>

<template>
    <div
        class="
            w-full px-[15px] md:px-[20px] grid gap-[18px] pb-[30px] pt-[60px] md:pt-[32px] transition-opacity
        "
        :class="{
            'opacity-30 pointer-events-none': isBusy,
        }"
    >
        <slot/>
    </div>
</template>
