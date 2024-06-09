<script setup>
const props = defineProps({
    context: {type: String, default: 'menu'},
})
</script>


<template>
    <div
        class="grid items-start md:grid-cols-2 gap-[30px] lg:gap-[50px]"
        :class="{
            'lg:grid-cols-3' : context === 'menu',
        }"
    >
        <slot/>
    </div>
</template>
