<script setup>
const props = defineProps({
    mode: {
        type: String,
        default: 'default'
    }
});
</script>

<template>
    <div
        class="w-[15px] h-full flex items-center justify-center"
        :class="{
            'bg-highlight': mode === 'default',
            'bg-error': mode === 'alert',
        }"
    >
        <div class="text-center transform rotate-[-90deg]">
            <slot />
        </div>
    </div>
</template>
