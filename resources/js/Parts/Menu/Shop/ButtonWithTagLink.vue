<script setup>
import ActiveArrow from './ActiveArrow.vue'

const props = defineProps({
    isActive: { type: Boolean, default: false },
})
</script>

<template>
    <div
        class="block py-[3px] pl-[10px] lg:pl-[20px] text-copy-xs"
        :class="{
            'bg-white': isActive,
        }"
    >
        <slot />

        <ActiveArrow v-show="isActive" />
    </div>
</template>
