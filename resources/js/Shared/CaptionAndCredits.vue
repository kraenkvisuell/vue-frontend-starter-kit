<script setup>
const props = defineProps({
    caption: {
        type: String,
        default: '',
    },
    credits: {
        type: String,
        default: '',
    },
})
</script>

<template>
    <div class="w-full mt-[8px] flex text-copy-sm justify-between gap-[30px] px-[10px]">
        <div v-html="caption"/>

        <div v-if="credits" class="text-gray-600" v-html="credits"/>
    </div>
</template>
