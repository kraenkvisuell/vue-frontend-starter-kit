<script setup>
const props = defineProps({
    text: String,
})
</script>


<template>
    <div class="
        font-bold text-copy-lg tracking-normal
        px-[30px] sm:px-[50px] md:px-[80px]
        pb-[40px] sm:pb-[60px]
    ">
        {{ text }}
    </div>
</template>

