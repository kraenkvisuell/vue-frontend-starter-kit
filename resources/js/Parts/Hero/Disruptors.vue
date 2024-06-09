<script setup>
import Disruptor from './Disruptors/Disruptor.vue'

const props = defineProps({
    entry: {
        type: Object,
        default: {},
    }
})
</script>

<template>
    <div v-if="entry.hero_disruptors" class="pointer-events-none absolute inset-0 z-0 h-full w-full">
        <Disruptor v-for="disruptor in entry.hero_disruptors" :disruptor="disruptor"/>
    </div>
</template>
