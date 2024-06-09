<script setup>
const props = defineProps({
    headline: {type: String, default: ''},
    text: {type: String, default: ''},
})
</script>

<template>
    <div
        class=" flex gap-[20px] text-gray-800 text-copy-sm border-b border-gray-600"
        :class="{
            'pt-[4px] pb-[6px]' : headline,
            'pt-[6px] pb-[7px]' : !headline,
        }"
    >
        <div v-if="headline"
             class="w-[120px] flex-shrink-0 text-copy-xs font-medium tracking-wide uppercase mt-[2px]">
            {{ headline }}
        </div>

        <div class="place-self-end" v-html="text"/>
    </div>
</template>
