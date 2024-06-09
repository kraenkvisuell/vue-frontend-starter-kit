<script setup>
const props = defineProps({
    required: {type: Boolean, default: false},
    bold: {type: Boolean, default: false},
})
</script>

<template>
    <label class="text-copy-sm text-gray-800 pl-[6px]">
        <span :class="{ 'font-semibold': bold }">
            <slot/>
        </span>
        <span v-if="required">*</span>
    </label>
</template>
