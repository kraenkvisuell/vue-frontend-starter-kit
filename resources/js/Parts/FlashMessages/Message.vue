<script setup>
const props = defineProps({
    showMessage: {type: Boolean, default: false}
})
</script>

<template>
    <Transition>
        <div
            v-if="showMessage"
            class="
            pointer-events-auto rounded full bg-highlight/80 shadow
            text-white px-[24px] py-[12px] leading-tightest
            max-w-[800px]
        "
        >
            <slot/>
        </div>
    </Transition>
</template>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
