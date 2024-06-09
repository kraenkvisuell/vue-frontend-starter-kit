<script setup>
const props = defineProps({
    isOpen: Boolean,
    clickMethod: Function,
})
</script>

<template>
    <Transition>
        <button
            v-show="isOpen"
            class="w-full h-screen absolute top-0 left-0 bg-darkest opacity-75"
            @click="clickMethod"
        >
        </button>
    </Transition>
</template>
