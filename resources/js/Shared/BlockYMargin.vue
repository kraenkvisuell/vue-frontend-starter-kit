<script setup>
defineProps({
    size: {
        type: String, default: 'md'
    },
})
</script>

<template>
    <div :class="{
        'my-[40px] lg:my-[60px]': size === 'md',
    }">
        <slot/>
    </div>
</template>
