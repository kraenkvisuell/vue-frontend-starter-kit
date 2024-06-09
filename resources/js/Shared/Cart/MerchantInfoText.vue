<script setup>
const props = defineProps({
    context: String,
})
</script>

<template>
    <div class="
        md:col-span-2 editor mx-[16px] md:mx-0 md:top-[-16px]
        is-small-editor text-copy-sm grid gap-[25px] mt-[60px]
    ">
        <div v-html="$shared.globals.merchants.cart_bottom_info.text"/>

        <div v-html="$shared.globals.merchants.general_help_text.text"/>
    </div>
</template>
