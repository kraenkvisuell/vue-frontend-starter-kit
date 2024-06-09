<script setup>
import { useColors } from '../Composables/useColors.js'
import CheckMark from '../Svg/CheckMark.vue'
import { computed } from 'vue'

const { lightOrDark } = useColors()

const props = defineProps({
    isSelected: { type: Boolean, default: false },
    bgColor: { type: String, default: '#000000' },
})

let textColor = computed(() => lightOrDark(props.bgColor) === 'dark' ? 'white' : 'black')
let innerBorderColor = computed(() => lightOrDark(props.bgColor) === 'extralight' ? '#cccccc' : (props.bgColor))
</script>

<template>
    <button
        class="
            w-[32px] h-[32px] rounded-full border-[1.5px] flex items-center justify-center
            text-copy-xl capitalize leading-none
        "
        :style="{
            'background-color': isSelected ? bgColor : 'transparent',
            'border-color': isSelected ? innerBorderColor: '#cccccc',
            'color': textColor,
        }"
    >
        <span v-if="isSelected" class="block h-[67%] mt-[8%]">
            <CheckMark />
        </span>
    </button>
</template>
