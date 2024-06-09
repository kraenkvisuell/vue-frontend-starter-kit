<script setup>
import ContentBlock from './ContentBlock.vue'

const props = defineProps({
    blocks: Array,
    default: [],
})
</script>

<template>
    <div class="w-full">
        <ContentBlock v-for="block in blocks" :block="block" />
    </div>
</template>
