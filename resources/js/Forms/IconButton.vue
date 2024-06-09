<script setup>

const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
})

</script>
<template>
    <div
        class="
            w-[38px] h-[38px] flex items-center justify-center
            rounded-full bg-white fill-black
            hover:bg-black hover:fill-white transition-colors duration-400
        "
        :class="{
            'opacity-30 cursor-not-allowed pointer-events-none': disabled,
        }"
    >
        <slot />
    </div>
</template>
