<script setup>
const props = defineProps({
    level: {type: String, default: 'h2'},
})
</script>

<template>
    <component :is="level">
        <slot/>
    </component>
</template>
