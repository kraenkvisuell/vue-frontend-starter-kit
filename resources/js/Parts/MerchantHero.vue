<script setup>
import Hero from './Hero.vue'
import {computed} from 'vue'

const props = defineProps({
    title: String,
})

const entryForHero = computed(() => {
    let entry = $shared.globals.shop
    
    entry.title = props.title
    entry.show_title = true
    return entry
})
</script>

<template>
    <Hero :entry="entryForHero"/>
</template>
