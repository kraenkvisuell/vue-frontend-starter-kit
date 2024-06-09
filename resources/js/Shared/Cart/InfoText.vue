<script setup>
const props = defineProps({
    context: String,
})
</script>

<template>
    <div
        class=" md:col-span-2 editor mx-[16px] md:mx-0 md:top-[-16px] is-small-editor text-copy-sm"
        :class="{
            'lg:col-span-1 lg:mt-[7px]' : context === 'menu',
        }"
        v-html="$shared.globals.shop.cart_bottom_info.text"
    />
</template>
