<script setup>
const props = defineProps({
    text: {
        type: String,
        default: '',
    },
})

//console.log(props.text)
</script>

<template>
    <div class="mt-[8px]" v-html="text"/>
</template>
