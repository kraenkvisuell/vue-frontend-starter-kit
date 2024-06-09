<script setup>
import { useColors } from '../Composables/useColors.js'

const { lightOrDark } = useColors()

const props = defineProps({
    bgColor: {
        type: String, default: $shared.defaultBgColor,
    },
})

let textColor = lightOrDark(props.bgColor) === 'light' ? 'text-black' : 'text-white'
</script>


<template>
    <div :class="[textColor]" :style="{backgroundColor: bgColor}">
        <slot />
    </div>
</template>
